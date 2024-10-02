<?php


namespace Admin\Models;

use Admin\Models\Traits\RelationsTrait;

/**
 * Class MenuitemsModel
 * @package Admin\Models
 */
class MenuitemsModel extends BaseModel
{
    use RelationsTrait;

    /** @inheritdoc */
    protected $table = 'menuitems';

    /** @inheritdoc */
    protected $returnType = 'Admin\Models\Entities\Menuitem';

    /** @inheritdoc */
    protected $beforeInsert = ['beforeInsertTree'];

    /** @inheritdoc */
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
        'li_class',
        'li_attributes',
        'a_class',
        'a_attributes',
        'lft',
        'rgt'
    ];

    /**
     * @inheritdoc
     */
    public function initialize()
    {
        $this->hasMany('menu_translations', [
            'foreign_key' => 'menuitem_id',
            'entity' => 'Admin\Models\Entities\MenuTranslation'
        ]);
    }

    /**
     * Get Children of Tree
     * @param $menu_id
     * @param $node
     * @param $parent_id
     * @return array|mixed
     */
    public function getChildren($menu_id, &$node = [], $parent_id = null)
    {
        $query = $this->where('menu_id', $menu_id)
            ->where('parent_id', $parent_id)
            ->groupBy('lft')
            ->orderBy('lft');

        if ($this->translationEnabeld) {
            $query = $query->with('menu_translations');
        }

        $results = $query->findAll();

        foreach ($results as $result) {
            $result = $result->toArray();
            $result['children'] = [];

            if ($this->translationEnabeld) {
                $result['translations'] = [];
                if (!empty($result['menu_translations'])) {
                    foreach ($result['menu_translations'] as $translation) {
                        $result['translations'][$translation->language] = $translation;
                    }
                }

                $languages = array_diff(
                    config('Admin\Config\SystemSettings')->supportedTranslations,
                    [config('Admin\Config\SystemSettings')->language]
                );
                foreach ($languages as $language) {
                    if (!isset($result['translations'][$language])) {
                        $result['translations'][$language] = [
                            'menuitem_id' => $result['id'],
                            'language' => $language,
                            'title' => '',
                        ];
                    }
                }

                unset($result['menu_translations']);
            }

            $row = $this->builder->where('parent_id', $result['id'])->get()->getFirstRow();
            if ($row) {
                $this->getChildren($menu_id, $result['children'], $result['id']);
            }

            $node[] = $result;
        }

        return $node;
    }

    /**
     * creates a nested tree from the menuitems
     *
     * @param int $menu_id
     * @return mixed
     */
    public function findTree(int $menu_id)
    {
        return $this->getChildren($menu_id);
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
            ->where('menu_id', $nodeToMove->menu_id)
            ->orderBy('lft')
            ->get()
            ->getResult();
        $nodesToMoveDown = $this
            ->where("lft BETWEEN $upperNode->lft AND $upperNode->rgt")
            ->where('menu_id', $nodeToMove->menu_id)
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

        $menuId = $item->menu_id;
        $rgt = $item->rgt;
        $lft = $item->lft;

        if ($rgt - $lft == 1) {
            // remove single
            $builder->delete("id={$item->id} AND menu_id = {$menuId}");
            $this->db->query("UPDATE menuitems SET lft=lft-2 WHERE lft>{$rgt} AND menu_id = {$menuId}");
            $this->db->query("UPDATE menuitems SET rgt=rgt-2 WHERE rgt>{$rgt} AND menu_id = {$menuId}");
            $this->_removeTranslation($item->id);
            return true;
        } elseif (($rgt - $lft > 1) && $removeTree) {
            // remove tree
            $builder->delete("(lft BETWEEN $lft AND $rgt) AND menu_id = {$menuId}");
            $this->db->query(
                'UPDATE menuitems SET lft=lft-ROUND(' . ($rgt - $lft + 1) . ') WHERE lft>' . $rgt . ' AND menu_id = ' . $menuId
            );
            $this->db->query(
                'UPDATE menuitems SET rgt=rgt-ROUND(' . ($rgt - $lft + 1) . ') WHERE rgt>' . $rgt . ' AND menu_id = ' . $menuId
            );
            $this->_removeTranslation($item->id);
            return true;
        } elseif (($rgt - $lft > 1) && !$removeTree) {
            // remove single but keep elements below the item
            $parentId = is_null($item->parent_id) ? 'NULL' : $item->parent_id;
            $builder->delete("id=$item->id AND menu_id = {$menuId}");
            $this->db->query(
                "UPDATE menuitems SET lft=lft-1, rgt=rgt-1, parent_id=$parentId WHERE lft BETWEEN $lft AND $rgt AND menu_id = {$menuId}"
            );
            $this->db->query("UPDATE menuitems SET lft=lft-2 WHERE lft>$rgt AND menu_id = {$menuId}");
            $this->db->query("UPDATE menuitems SET rgt=rgt-2 WHERE rgt>$rgt AND menu_id = {$menuId}");
            $this->_removeTranslation($item->id);
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
        if (!isset($data['data']['parent_id']) || $data['data']['parent_id'] == '') {
            $menuId = $data['data']['menu_id'];
            $max = $this->db
                ->query('SELECT max(rgt) as maxRgt FROM menuitems WHERE menu_id = ' . $menuId)
                ->getRow();

            $data['data']['lft'] = $max->maxRgt + 1;
            $data['data']['rgt'] = $max->maxRgt + 2;
            if (!is_null($max->maxRgt)) {
                $this->db->query(
                    'UPDATE menuitems SET rgt=rgt+2 WHERE rgt > ' . $max->maxRgt . ' AND menu_id = ' . $menuId
                );
                $this->db->query(
                    'UPDATE menuitems SET lft=lft+2 WHERE lft > ' . $max->maxRgt . ' AND menu_id = ' . $menuId
                );
            }
        } else {
            $parentItem = $this->where('id', $data['data']['parent_id'])->first();
            $menuId = $parentItem->menu_id;
            $rgt = $parentItem->rgt;
            $data['data']['lft'] = $rgt;
            $data['data']['rgt'] = $rgt + 1;
            if ($parentItem) {
                $this->db->query('UPDATE menuitems SET rgt=rgt+2 WHERE rgt >= ' . $rgt . ' AND menu_id = ' . $menuId);
                $this->db->query('UPDATE menuitems SET lft=lft+2 WHERE lft > ' . $rgt . ' AND menu_id = ' . $menuId);
            }
        }

        return $data;
    }

    /**
     * remove all translations
     * @param $menuitem_id
     * @return void
     */
    private function _removeTranslation($menuitem_id)
    {
        if ($this->translationEnabeld) {
            $this->db->simpleQuery('DELETE FROM menu_translations WHERE menuitem_id = ' . $menuitem_id);
        }
    }
}
