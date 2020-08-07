<?php


namespace Admin\Models;


use CodeIgniter\Model;

class CategoriesModel extends Model
{
    protected $table = 'categories';
    protected $returnType = 'Admin\Models\Entities\Category';

    protected $useTimestamps = true;
    protected $updatedField = 'updated';
    protected $createdField = 'created';

    protected $allowedFields = [
        'name',
        'description',
        'is_system'
    ];

}