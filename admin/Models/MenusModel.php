<?php


namespace Admin\Models;


use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class MenusModel extends Model
{
    protected $table = 'menus';
    protected $returnType = 'Admin\Models\Entities\Menu';

    protected $MenuItems;

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);

        $this->MenuItems = new MenuitemsModel();
    }

    public function findAllMenusWithTrees()
    {
        $menus = $this->findAll();

        foreach ($menus as $menu) {
            $menu->tree = $this->MenuItems->findTree($menu->id);
        }

        return $menus;
    }
}