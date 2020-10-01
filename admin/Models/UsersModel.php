<?php


namespace Admin\Models;


use CodeIgniter\Model;
use Tests\Support\Models\UserModel;

class UsersModel extends BaseModel
{
    protected $table = 'users';
    protected $returnType = 'Admin\Models\Entities\User';
    protected $allowedFields = [
        'username',
        'password',
        'firstname',
        'lastname',
        'email',
        'role',
        'tries'
    ];
}