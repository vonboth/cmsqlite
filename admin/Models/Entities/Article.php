<?php


namespace Admin\Models\Entities;


use Admin\Models\CategoriesModel;
use CodeIgniter\Entity;

/**
 * Class Article
 * @package Admin\Models\Entities
 *
 * The Article Model
 *
 * @property int $id
 * @property bool $is_startpage
 * @property string $title
 * @property string $alias
 * @property string $doc_key
 * @property string $content
 * @property string $description
 * @property string $class
 * @property int $category_id
 * @property string $layout
 * @property int $user_id
 * @property string $published
 * @property string $start_publish
 * @property string $stop_publish
 * @property int $hits
 * @property string $created
 * @property string $updated
 */
class Article extends Entity
{
    protected $attributes = [
        'id' => null,
        'is_startpage' => null,
        'title' => null,
        'alias' => null,
        'doc_key' => null,
        'content' => null,
        'description' => null,
        'class' => null,
        'category_id' => null,
        'layout' => null,
        'user_id' => null,
        'published' => null,
        'start_publish' => null,
        'stop_publish' => null,
        'hits' => null,
        'created' => null,
        'updated' => null
    ];

    protected $dates = ['created', 'updated'];
}