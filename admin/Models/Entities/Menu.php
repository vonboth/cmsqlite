<?php


namespace Admin\Models\Entities;


/**
 * Class Menu
 * @package Admin\Models\Entities
 *
 * Menu model
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $created
 * @property string $updated
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

    protected $date = ['created', 'updated'];
}