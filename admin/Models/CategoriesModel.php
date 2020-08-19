<?php


namespace Admin\Models;


class CategoriesModel extends BaseModel
{
    protected $table = 'categories';
    protected $returnType = 'Admin\Models\Entities\Category';

    protected $allowedFields = [
        'name',
        'description',
        'is_system'
    ];

}