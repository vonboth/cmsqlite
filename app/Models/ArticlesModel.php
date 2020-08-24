<?php

namespace App\Models;

class ArticlesModel extends BaseModel
{
    protected $table = 'articles';
    protected $returnType = 'App\Models\Entities\Article';

    protected $useTimestamps = true;
    protected $updatedField = 'updated';
    protected $createdField = 'created';

    protected $beforeUpdate = ['setStartpageFlagToNull'];

    protected $relations = [
        'categories' => [
            'type' => 'belongsTo',
            'key' => 'category_id'
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
}