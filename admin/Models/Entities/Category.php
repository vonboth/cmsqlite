<?php

namespace Admin\Models\Entities;

use CodeIgniter\Entity;

class Category extends Entity
{
    protected $attributes = [
        'id' => null,
        'name' => null,
        'description' => null,
        'is_system' => null,
        'created' => null,
        'updated' => null,
    ];

    protected $dates = [
        'created',
        'updated',
    ];
}