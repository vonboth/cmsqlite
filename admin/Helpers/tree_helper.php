<?php

if (!function_exists('tree_list')) {
    /**
     * generates an unordered list from a nested set
     *
     * @param $levels
     * @return mixed
     */
    function menu_list($levels)
    {
        $ul = '<ul>';
        foreach ($levels[0] as $topLevel) {
            $ul .= "<li><a href='{$topLevel['url']}'>{$topLevel['title']}</a>";
            if (!empty($topLevel['list'])) {
                $ul .= "<ul>{$topLevel['list']}</ul>";
            }
            $ul .= "</li>";
        }
        $ul .= "</ul>\n";
        return $ul;
    }
}