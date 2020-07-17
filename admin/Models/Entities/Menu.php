<?php


namespace Admin\Models\Entities;


use CodeIgniter\Entity;

class Menu extends Entity
{
    protected $attributes = [
        'id' => null,
        'name' => null,
        'description' => null,
        'created' => null,
        'updated' => null,
    ];

    protected $dates = [
        'created',
        'updated',
    ];
}