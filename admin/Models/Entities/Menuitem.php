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
        'alias' => null,
        'target' => null,
        'lft' => null,
        'rgt' => null,
        'created' => null,
        'updated' => null,
    ];

    protected $dates = ['created', 'updated'];
}