<?php


namespace Admin\Models;


use CodeIgniter\Model;

class MenuitemsModel extends Model
{
    protected $table = 'menuitems';
    protected $returnType = 'Admin\Models\Entities\Menuitem';

    protected $beforeInsert = ['beforeInsertTree'];

    public function findLeveledNodes($menu_id = null)
    {
        /*SELECT node.title, node.parent_id, COUNT(*)-1 AS level
            FROM menuitems AS node, menuitems AS parent
            WHERE node.lft BETWEEN parent.lft AND parent.rgt
            GROUP BY node.lft
            ORDER BY node.lft*/
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

        return $levels[0];
    }

    public function moveUp()
    {
    }

    public function moveDown()
    {
    }

    public function recover()
    {
    }

    public function removeFromTree()
    {
    }

    protected function beforeInsertTree(array $data)
    {
        $builder = $this->builder();
        $builder->update(['rgt' => 'rgt + 2'], "rgt >= {$data['rgt']}");
    }
}