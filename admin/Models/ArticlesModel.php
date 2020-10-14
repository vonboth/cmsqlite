<?php

namespace Admin\Models;

use Admin\Services\AuthService;
use Tatter\Relations\Traits\ModelTrait;

/**
 * Class ArticlesModel
 * @package App\Models
 */
class ArticlesModel extends BaseModel
{
    use ModelTrait;

    protected $table = 'articles';
    protected $returnType = 'Admin\Models\Entities\Article';

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
     * @return array
     */
    protected function setStartpageFlagToNull(array $data)
    {
        if (isset($data['data']['is_startpage'])) {
            $this->db->query('UPDATE articles SET is_startpage=NULL');
        }
        return $data;
    }

    /**
     * set the user id for
     * the article
     * @param array $data
     * @return array
     */
    protected function setUser(array $data)
    {
        /** @var AuthService $authService */
        $authService = service('auth');
        $user = $authService->getUser();
        $data['user_id'] = $user['id'];
        return $data;
    }

    protected function unsetPassword($data)
    {
        var_dump($data); exit;
    }
}