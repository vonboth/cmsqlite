<?php


namespace Admin\Models;

/**
 * Class MenuitemsModel
 * @package Admin\Models
 */
class MenuitemsModel extends BaseModel
{
    protected $table = 'menuitems';
    protected $returnType = 'Admin\Models\Entities\Menuitem';
    protected $beforeInsert = ['beforeInsertTree'];
    protected $allowedFields = [
        'id',
        'title',
        'parent_id',
        'menu_id',
        'article_id',
        'category_id',
        'type',
        'url',
        'alias',
        'target',
        'lft',
        'rgt'
    ];

    /**
     * get home menu item
     * @return array|object|null
     */
    public function getStartpageItem()
    {
        return $this->where('url', '/')
            ->first();
    }

    /**
     * @param null $menu_id
     * @return array
     */
    public function findLeveledNodes($menu_id = null)
    {
        $builder = $this->builder();
        $builder
            ->select(
                [
                    'node.id',
                    'node.title',
                    'node.parent_id',
                    'node.menu_id',
                    'node.url',
                    'node.lft',
                    'node.rgt',
                    'COUNT(*)-1 AS level'
                ]
            )
            ->from('menuitems AS node', 1)
            ->from('menuitems AS parent')
            ->where('node.lft BETWEEN parent.lft AND parent.rgt')
            ->groupBy('node.lft')
            ->orderBy('node.lft');

        if (!is_null($menu_id)) {
            $builder->where(['node.menu_id' => $menu_id]);
        }

        return $builder
            ->get()
            ->getResultArray();
    }

    /**
     * creates a nested tree from the menuitems
     *
     * @param null $menu_id
     * @return mixed
     */
    public function findTree($menu_id = null)
    {
        $tree = $this->findLeveledNodes($menu_id);

        $levels = [];
        foreach ($tree as $item) {
            $item['children'] = [];
            $levels[$item['level']][$item['id']] = $item;
        }

        for ($i = count($levels) - 1; $i >= 1; $i--) {
            foreach ($levels[$i] as $level) {
                foreach ($levels[$i - 1] as $parent_level) {
                    if ($level['parent_id'] == $parent_level['id']) {
                        $levels[$i - 1][$level['parent_id']]['children'][] = $level;
                    }
                }
            }
        }

        if (count($levels) == 0) {
            return [];
        }
        return $levels[0];
    }

    /**
     * Move an item up within
     * it's branch (lft/rgt borders)
     *
     * @param int|null $id the id of the item
     * @return bool
     */
    public function moveUp($id = null)
    {
        $nodeToMove = $this->find($id);
        return $this->_move($nodeToMove);
    }

    /**
     * move an item down within
     * it's branch (lft/rgt borders)
     *
     * @param int|null $id the id of the item
     * @return bool
     */
    public function moveDown($id)
    {
        $nodeToMove = $this->find($id);
        $lowerNode = $this
            ->where('lft', ($nodeToMove->rgt + 1))
            ->where('menu_id', $nodeToMove->menu_id)
            ->first();

        return $this->_move($lowerNode);
    }

    /**
     * Move node
     *
     * @param array|null|object $nodeToMove
     *
     * @return bool
     */
    private function _move($nodeToMove)
    {
        $upperNode = $this
            ->where('rgt', ($nodeToMove->lft - 1))
            ->where('menu_id', $nodeToMove->menu_id)
            ->first();

        // no item available? return;
        if (!$upperNode) {
            return true;
        }
        $lftDist = $nodeToMove->lft - $upperNode->lft;
        $rgtDist = $nodeToMove->rgt - $upperNode->rgt;

        $nodesToMoveUp = $this
            ->where("lft BETWEEN $nodeToMove->lft AND $nodeToMove->rgt")
            ->orderBy('lft')
            ->get()
            ->getResult();
        $nodesToMoveDown = $this
            ->where("lft BETWEEN $upperNode->lft AND $upperNode->rgt")
            ->orderBy('lft')
            ->get()
            ->getResult();

        try {
            // set lft/rgt for node in new pos
            foreach ($nodesToMoveUp as $node) {
                $node->lft = $node->lft - $lftDist;
                $node->rgt = $node->rgt - $lftDist;
                $this->save($node);
            }

            // set lft/rgt for node moved down
            foreach ($nodesToMoveDown as $node) {
                $node->lft = $node->lft + $rgtDist;
                $node->rgt = $node->rgt + $rgtDist;
                $this->save($node);
            }
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }


    /**
     * before delete handler
     * for deleting menuitems
     * - recover lft/rgt values
     * @param int $id
     * @param bool $removeTree whether to remove the complete branch
     * @return bool
     */
    public function removeFromTree($id, $removeTree = false)
    {
        /* einzelnes entfernen
         * DELETE FROM tree WHERE lft=3;
	        UPDATE tree SET lft=lft-2 WHERE lft>4;
	        UPDATE tree SET rgt=rgt-2 WHERE rgt>4;
         *
         * ganzen Baum löschen
         * DELETE FROM tree WHERE lft BETWEEN $LFT AND $RGT;
	        UPDATE tree SET lft=lft-ROUND(($RGT-$LFT+1)) WHERE lft>$RGT;
	        UPDATE tree SET rgt=rgt-ROUND(($RGT-$LFT+1)) WHERE rgt>$RGT;
         *
         * erhalten
         * DELETE FROM tree WHERE lft = $LFT;
	        UPDATE tree SET lft=lft-1, rgt=rgt-1 WHERE lft BETWEEN $LFT AND $RGT;
	        UPDATE tree SET lft=lft-2 WHERE lft>$RGT;
	        UPDATE tree SET rgt=rgt-2 WHERE rgt>$RGT;
         */

        $builder = $this->builder();
        $item = $this->find($id);
        if (!$item) {
            return false;
        }

        $rgt = $item->rgt;
        $lft = $item->lft;

        if ($rgt - $lft == 1) {
            // remove single
            $builder->delete("id={$item->id}");
            $this->db->query("UPDATE menuitems SET lft=lft-2 WHERE lft>{$rgt}");
            $this->db->query("UPDATE menuitems SET rgt=rgt-2 WHERE rgt>{$rgt}");
            return true;
        } elseif (($rgt - $lft > 1) && $removeTree) {
            // remove tree
            $builder->delete("lft BETWEEN $lft AND $rgt");
            $this->db->query(
                'UPDATE menuitems SET lft=lft-ROUND(' . ($rgt - $lft + 1) . ') WHERE lft>' . $rgt
            );
            $this->db->query(
                'UPDATE menuitems SET rgt=rgt-ROUND(' . ($rgt - $lft + 1) . ') WHERE rgt>' . $rgt
            );
            return true;
        } elseif (($rgt - $lft > 1) && !$removeTree) {
            // remove single but keep elements below the item
            $parentId = is_null($item->parent_id) ? 'NULL' : $item->parent_id;
            $builder->delete("id=$item->id");
            $this->db->query(
                "UPDATE menuitems SET lft=lft-1, rgt=rgt-1, parent_id=$parentId WHERE lft BETWEEN $lft AND $rgt"
            );
            $this->db->query("UPDATE menuitems SET lft=lft-2 WHERE lft>$rgt");
            $this->db->query("UPDATE menuitems SET rgt=rgt-2 WHERE rgt>$rgt");
        }
        return false;
    }

    /**
     * Update the tree before inserting
     * a new menuitem
     * @param array $data
     * @return array
     */
    protected function beforeInsertTree(array $data)
    {
        if (!isset($data['data']['parent_id'])) {
            $max = $this->select('max(rgt) as maxRgt')
                //->where('menu_id', $data['data']['menu_id'])
                ->first();

            $data['data']['lft'] = $max->maxRgt + 1;
            $data['data']['rgt'] = $max->maxRgt + 2;
            if (!is_null($max->maxRgt)) {
                $this->db->query('UPDATE menuitems SET rgt=rgt+2 WHERE rgt > ' . $max->maxRgt);
                $this->db->query('UPDATE menuitems SET lft=lft+2 WHERE lft > ' . $max->maxRgt);
            }
        } else {
            $parentItem = $this->where('id', $data['data']['parent_id'])->first();
            $rgt = $parentItem->rgt;
            $data['data']['lft'] = $rgt;
            $data['data']['rgt'] = $rgt + 1;
            if ($parentItem) {
                $this->db->query('UPDATE menuitems SET rgt=rgt+2 WHERE rgt >= ' . $rgt);
                $this->db->query('UPDATE menuitems SET lft=lft+2 WHERE lft > ' . $rgt);
            }
        }

        return $data;
    }
}