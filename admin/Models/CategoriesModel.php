<?php


namespace Admin\Models;


use CodeIgniter\Model;

class CategoriesModel extends Model
{
    protected $table = 'categories';
    protected $returnType = 'Admin\Models\Entities\Category';

}