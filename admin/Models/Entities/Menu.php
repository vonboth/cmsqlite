<?php


namespace Admin\Models\Entities;


use CodeIgniter\Entity;

/**
 * Class Menu
 * @package Admin\Models\Entities
 */
class Menu extends Base
{
    protected $attributes = [
        'id' => null,
        'name' => null,
        'description' => null,
        'created' => null,
        'updated' => null,
    ];
}