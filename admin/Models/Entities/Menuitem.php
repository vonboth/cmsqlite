<?php


namespace Admin\Models\Entities;


use CodeIgniter\Entity;

class Menuitem extends Entity
{
    protected $attributes = [
        'id' => null,
        'title' => null,
        'parent_id' => null,
        'menu_id' => null,
        'article_id' => null,
        'url' => null,
        'created' => null,
        'updated' => null,
        'lft' => null,
        'rght' => null,
    ];

    protected $dates = [
        'created',
        'updated',
    ];
}