<?php


namespace Admin\Models\Entities;

/**
 * Class Menuitem
 * @package Admin\Models\Entities
 *
 * Menu item model
 *
 * @property int $id
 * @property string $title
 * @property int $parent_id
 * @property int $menu_id
 * @property int $article_id
 * @property int $category_id
 * @property string $type
 * @property string $url
 * @property string $alias
 * @property string $target
 * @property string $layout
 * @property int $lft
 * @property int $rgt
 * @property string $created
 * @property string $updated
 */
class Menuitem extends Base
{
    protected $attributes = [
        'id' => null,
        'title' => null,
        'parent_id' => null,
        'menu_id' => null,
        'article_id' => null,
        'category_id' => null,
        'type' => null,
        'url' => null,
        'alias' => null,
        'target' => null,
        'layout' => null,
        'lft' => null,
        'rgt' => null,
        'created' => null,
        'updated' => null,
    ];

    protected $dates = ['created', 'updated'];
}