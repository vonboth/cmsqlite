<?php

namespace App\Models;

use Admin\Services\AuthService;

/**
 * Class ArticlesModel
 * @package App\Models
 */
class ArticlesModel extends BaseModel
{
    protected $table = 'articles';
    protected $returnType = 'App\Models\Entities\Article';

    protected $useTimestamps = true;
    protected $updatedField = 'updated';
    protected $createdField = 'created';

    protected $beforeUpdate = ['setStartpageFlagToNull'];
    protected $beforeInsert = ['setUser'];

    protected $relations = [
        'categories' => [
            'type' => 'hasOne',
            'key' => 'category_id'
        ],
        'users' => [
            'type' => 'hasOne',
            'key' => 'user_id'
        ]
    ];

    protected $allowedFields = [
        'is_startpage',
        'title',
        'alias',
        'doc_key',
        'content',
        'description',
        'class',
        'category_id',
        'user_id',
        'published',
        'start_publish',
        'stop_publish',
    ];

    /**
     * set all flags is_startpage to null
     * so that we will have only one startpage
     *
     * @param array $data
     */
    protected function setStartpageFlagToNull(array $data)
    {
        if ($data['data']['is_startpage']) {
            $this->db->query('UPDATE articles SET is_startpage=NULL');
        }
    }

    /**
     * set the user id for the creat
     * @param array $data
     */
    protected function setUser(array $data)
    {
        /** @var AuthService $authService */
        $authService = service('auth');
        $user = $authService->getUser();
        $data['user_id'] = $user['id'];
    }
}