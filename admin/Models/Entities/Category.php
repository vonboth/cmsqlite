<?php

namespace Admin\Models\Entities;

/**
 * Class Category
 * @package Admin\Models\Entities
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