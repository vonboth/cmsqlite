<?php


namespace Admin\Models\Entities;


use CodeIgniter\Entity;

class User extends Entity
{
    protected $attributes = [
        'id' => null,
        'username' => null,
        'password' => null,
        'firstname' => null,
        'lastname' => null,
        'email' => null,
        'role' => null,
        'created' => null,
        'updated' => null,
    ];

    protected $dates = [
        'created',
        'updated',
    ];
}