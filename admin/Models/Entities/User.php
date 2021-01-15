<?php


namespace Admin\Models\Entities;


use CodeIgniter\Entity;

/**
 * Class User
 * @package Admin\Models\Entities
 *
 * User Model
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $role
 * @property int $tries
 * @property string $lastlogin
 * @property string $created
 * @property string $updated
 */
class User extends Entity
{
    /** @inheritdoc */
    protected $attributes = [
        'id' => null,
        'username' => null,
        'password' => null,
        'firstname' => null,
        'lastname' => null,
        'email' => null,
        'role' => null,
        'tries' => null,
        'lastlogin' => null,
        'created' => null,
        'updated' => null,
    ];

    /**
     * dates fields
     */
    protected $dates = ['lastlogin'];

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

    /**
     * get fullname out of first and last name
     * @return string
     */
    protected function getFullname(): string
    {
        return $this->attributes['firstname'] . ' ' . $this->attributes['lastname'];
    }
}