<?php


namespace Admin\Models\Entities;

/**
 * Class Menuitem
 * @package Admin\Models\Entities
 */
class Menuitem extends Base
{
    protected $attributes = [
        'id' => null,
        'title' => null,
        'parent_id' => null,
        'menu_id' => null,
        'article_id' => null,
        'type' => null,
        'url' => null,
        'alias',
        'layout',
        'target',
        'created' => null,
        'updated' => null,
        'lft' => null,
        'rght' => null,
    ];
}