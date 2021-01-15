<?php

namespace Admin\Models\Entities;

/**
 * Class Category
 * @package Admin\Models\Entities
 *
 * Category Model
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property bool $is_system
 * @property string $created
 * @property string $updated
 */
class Category extends Base
{
    protected $attributes = [
        'id' => null,
        'name' => null,
        'description' => null,
        'is_system' => null,
        'created' => null,
        'updated' => null,
    ];

    protected $dates = ['created', 'updated'];
}