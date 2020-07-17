<?php


namespace Admin\Models;


use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $returnType = 'Admin\Models\Entities\User';
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    protected $allowedFields = [
        'username',
        'password',
        'firstname',
        'lastname',
        'email',
        'role',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created';
    protected $updatedField = 'updated';

    /**
     * Hash Password before handling
     * User data
     * @param array $data
     * @return array
     */
    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        return $data;
    }
}