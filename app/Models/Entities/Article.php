<?php


namespace App\Models\Entities;


use CodeIgniter\Entity;

class Article extends Entity
{
    protected $attributes = [
        'id' => null,
        'is_startpage' => null,
        'title' => null,
        'alias' => null,
        'doc_key' => null,
        'content' => null,
        'description' => null,
        'class' => null,
        'category_id' => null,
        'published' => null,
        'start_publish' => null,
        'stop_publish' => null,
        'created' => null,
        'updated' => null,
    ];
}