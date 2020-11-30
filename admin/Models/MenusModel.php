<?php


namespace Admin\Models;


use Admin\Controllers\Menuitems;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;
use Tatter\Relations\Traits\ModelTrait;

class MenusModel extends BaseModel
{
    use ModelTrait;

    protected $table = 'menus';
    protected $returnType = 'Admin\Models\Entities\Menu';
    protected $MenuItems;
    protected $allowedFields = [
        'name',
        'description'
    ];

    protected $afterDelete = ['afterDelete'];

    protected $relations = [
        'menuitems' => [
            'type' => 'hasMany',
            'key' => 'menu_id'
        ]
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
     * this adds the "nested tree" to
     * the menu as tree property
     * @return array
     */
    public function findAllMenusWithTrees() : array
    {
        $entities = $this->findAll();
        $menus = [];

        foreach ($entities as $entity) {
            $entity->tree = $this->MenuItems->findTree($entity->id);
            $menus[$entity->name] = $entity;
        }

        return $menus;
    }

    /**
     * handle after deleting a menu
     * - delete all menuitems related to the menu
     *
     * @param array $data
     *
     * @return void
     */
    public function afterDelete(array $data): void
    {
        if ($data['result']) {
            $Menuitems = new MenuitemsModel();
            $items = $Menuitems->where('menu_id', $data['id'])
                ->get()
                ->getResult();

            foreach ($items as $item) {
                $Menuitems->delete($item->id);
            }
        }
    }
}