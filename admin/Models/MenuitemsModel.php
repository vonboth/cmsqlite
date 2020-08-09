<?php


namespace Admin\Models;


use CodeIgniter\Model;

class MenuitemsModel extends Model
{
    protected $table = 'menuitems';
    protected $returnType = 'Admin\Models\Entities\Menuitem';

    public function findTreeList()
    {
        /*SELECT node.title, node.parent_id, COUNT(*)-1 AS level
            FROM menuitems AS node, menuitems AS parent
            WHERE node.lft BETWEEN parent.lft AND parent.rght
            GROUP BY node.lft
            ORDER BY node.lft*/
        $tree = $this->builder()
            ->select(
                [
                    'node.id',
                    'node.title',
                    'node.parent_id',
                    'node.menu_id',
                    'node.url',
                    'COUNT(*)-1 AS level'
                ]
            )
            ->from('menuitems AS node', 1)
            ->from('menuitems AS parent')
            ->where('node.lft BETWEEN parent.lft AND parent.rght')
            ->groupBy('node.lft')
            ->orderBy('node.lft')
            ->get()
            ->getResultArray();

        $levels = [];
        foreach ($tree as $item) {
            $item['children'] = [];
            $item['list'] = '';
            $levels[$item['level']][$item['id']] = $item;
        }

        for ($i = count($levels) - 1; $i >= 1; $i--) {
            foreach ($levels[$i] as $level) {

                $li = "<li>\n<a href='{$level['url']}'>{$level['title']}</a>\n";

                if (!empty($level['list'])) {
                    $li .= "<ul>\n{$level['list']}\n</ul>\n";
                }
                $li .= "</li>\n";

                foreach ($levels[$i - 1] as $parent_level) {
                    if ($level['parent_id'] == $parent_level['id']) {
                        $levels[$i - 1][$level['parent_id']]['children'][] = $level;
                        $levels[$i - 1][$level['parent_id']]['list'] .= $li;
                    }
                }
            }
        }

        return $levels;
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
}