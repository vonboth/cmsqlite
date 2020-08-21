<?php


namespace Admin\Models;


class MenuitemsModel extends BaseModel
{
    protected $table = 'menuitems';
    protected $returnType = 'Admin\Models\Entities\Menuitem';
    protected $beforeInsert = ['beforeInsertTree'];
    protected $beforeDelete = ['beforeDelete'];
    protected $allowedFields = [
        'id',
        'title',
        'parent_id',
        'menu_id',
        'article_id',
        'type',
        'url',
        'alias',
        'layout',
        'target',
        'lft',
        'rgt'
    ];

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
     */
    public function moveUp($id = null)
    {
    }

    /**
     * move an item down within
     * it's branch (lft/rgt borders)
     *
     * @param int|null $id the id of the item
     */
    public function moveDown($id)
    {
    }

    /**
     * before delete handler
     * for deleting menuitems
     * - recover lft/rgt values
     * @param array $data
     */
    public function beforeDelete(array $data)
    {
    }

    /**
     * Update the tree before inserting
     * a new menuitem
     * @param array $data
     * @return array
     */
    protected function beforeInsertTree(array $data)
    {
        $builder = $this->builder();
        $max = $builder->select('max(rgt) as maxRgt')
            ->get()
            ->getResult()[0];

        if (!$data['data']['parent_id']) {
            $data['data']['lft'] = $max->maxRgt + 1;
            $data['data']['rgt'] = $max->maxRgt + 2;
        } elseif ($data['data']['parent_id']) {
            $parentItem = $this->where('id', $data['data']['parent_id'])->first();
            $rgt = $parentItem->rgt;
            $data['data']['lft'] = $rgt;
            $data['data']['rgt'] = $rgt + 1;
            $this->db->query('UPDATE menuitems SET rgt=rgt+2 WHERE rgt >= ' . $rgt);
            $this->db->query('UPDATE menuitems SET lft=lft+2 WHERE lft > ' . $rgt);
        }

        return $data;
    }
}