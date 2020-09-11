<?php


namespace Admin\Models\Entities;

/**
 * Class Setting
 * @package Admin\Models\Entities
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
}