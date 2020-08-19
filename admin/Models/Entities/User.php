<?php


namespace Admin\Models\Entities;


use CodeIgniter\Entity;

/**
 * Class User
 * @package Admin\Models\Entities
 */
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

    /**
     * Hash Password before handling
     * User data
     * @param string $password
     * @return User
     */
    protected function setPassword(string $password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_BCRYPT);
        return $this;
    }
}