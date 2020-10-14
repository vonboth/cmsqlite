<?php


namespace Admin\Models;


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

    /*/**
     * Find Author data for an article
     * DO NOT INCLUDE A USER DUE TO SECURITY REASONS
     *
     * @param $id
     * @return array|object|null
     */
    public function findAuthor($id)
    {
        $author = $this->find($id);
        unset($author->username);
        unset($author->password);
        unset($author->role);
        unset($author->tries);
        unset($author->created);
        unset($author->updated);

        return $author;
    }
}