<?php


namespace Admin\Models\Entities;


use Admin\Models\CategoriesModel;
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
        'user_id' => null,
        'published' => null,
        'start_publish' => null,
        'stop_publish' => null,
        'created' => null,
        'updated' => null
    ];

    /**
     * @return array|object|null

    protected function getCategory()
    {
        $model = new CategoriesModel();
        return $model->find($this->category_id);
    }*/
}