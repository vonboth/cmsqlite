<?php


namespace Admin\Models;


use CodeIgniter\Model;

class MenusModel extends Model
{
    protected $table = 'menus';
    protected $returnType = 'Admin\Models\Entities\Menu';
}