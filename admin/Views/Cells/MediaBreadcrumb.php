<?php


namespace Admin\Views\Cells;


class MediaBreadcrumb
{
    public function render(array $params =[])
    {
        $content = '<nav class="blue lighten-2">' .
            '<div class="nav-wrapper">' .
            '<div class="col s12">';
        $count = count($params['path']);
        $content .= '<a class="breadcrumb" href="/admin/media/index">media</a>';

        for ($i = 0; $i < $count; $i++) {
            if (($i + 1) < $count) {
                $content .= '<a class="breadcrumb" 
                href="/admin/media/index?dir=' . $params['path'][$i] . '">' . $params['path'][$i] . '</a>';
            } else {
                $content .= '<span class="breadcrumb">' . $params['path'][$i] . '</span>';
            }
        }

        return $content . '</div></div></nav>';
    }
}