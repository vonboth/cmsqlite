<?php

namespace App\Models;

class ArticlesModel extends BaseModel
{
    protected $table = 'articles';
    protected $returnType = 'App\Models\Entities\Article';

    protected $useTimestamps = true;
    protected $updatedField = 'updated';
    protected $createdField = 'created';

    protected $allowedFields = [
        'is_startpage',
        'title',
        'alias',
        'doc_key',
        'content',
        'description',
        'class',
        'class',
        'category_id',
        'published',
        'start_publish',
        'stop_publish',
    ];
}