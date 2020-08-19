<?php


namespace Admin\Models;


use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;

class MenusModel extends BaseModel
{
    protected $table = 'menus';
    protected $returnType = 'Admin\Models\Entities\Menu';
    protected $MenuItems;
    protected $allowedFields = [
        'name',
        'description'
    ];

    /**
     * MenusModel constructor.
     * @param ConnectionInterface|null $db
     * @param ValidationInterface|null $validation
     */
    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->MenuItems = new MenuitemsModel();
    }

    /**
     * @return array
     */
    public function findAllMenusWithTrees()
    {
        $menus = $this->findAll();

        foreach ($menus as $menu) {
            $menu->tree = $this->MenuItems->findTree($menu->id);
        }

        return $menus;
    }
}