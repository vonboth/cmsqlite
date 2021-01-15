<?php


namespace Admin\Models\Entities;

/**
 * Class Setting
 * @package Admin\Models\Entities
 *
 * Settings Model
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $created
 * @property string $updated
 */
class Setting extends Base
{
    protected $attributes = [
        'id' => null,
        'name' => null,
        'value' => null,
        'created' => null,
        'updated' => null,
    ];

    protected $dates = ['created', 'updated'];
}