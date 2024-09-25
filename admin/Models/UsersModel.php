<?php


namespace Admin\Models;

/**
 * Class UsersModel
 * @package Admin\Models
 */
class UsersModel extends BaseModel
{
    /** @inheritdoc  */
    protected $table = 'users';

    /** @inheritdoc  */
    protected $returnType = 'Admin\Models\Entities\User';

    /** @inheritdoc  */
    protected $allowedFields = [
        'username',
        'password',
        'firstname',
        'lastname',
        'email',
        'role',
        'tries',
        'lastlogin'
    ];

    /*/**
     * Find Author data for an article
     * DO NOT INCLUDE A USER DUE TO SECURITY REASONS
     *
     * @param $id
     * @return array|object|null
     */
    /**
     * @return array|null|object
     */
    public function findAuthor($id = null)
    {
        if (is_null($id)) {
            return null;
        }

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
