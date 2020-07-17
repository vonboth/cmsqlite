<?php


namespace Admin\Models;


use CodeIgniter\Model;

class MenuitemsModel extends Model
{
    protected $table = 'menuitems';
    protected $returnType = 'Admin\Models\Entities\Menuitem';
}