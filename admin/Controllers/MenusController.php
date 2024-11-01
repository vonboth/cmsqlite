<?php


namespace Admin\Controllers;


use Admin\Models\ArticlesModel;
use Admin\Models\CategoriesModel;
use Admin\Models\Entities\Menu;
use Admin\Models\MenusModel;
use App\Exceptions\MethodNotAllowedException;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Class Articles
 * @package Admin\Controllers
 * @property MenusModel $Menus
 * @property ArticlesModel $Articles
 * @property CategoriesModel $Categories
 */
class MenusController extends BaseController
{
    /** @var MenusModel $Menus */
    protected $Menus;

    /** @var ArticlesModel $Articles */
    protected $Articles;

    /** @var CategoriesModel $Categories */
    protected $Categories;

    /**
     * init controller
     */
    public function initialize(): void
    {
        $this->Menus = new MenusModel();
        $this->Articles = new ArticlesModel();
        $this->Categories = new CategoriesModel();
    }

    /**
     * index page for menus
     *
     * @return string
     */
    public function index()
    {
        return view(
            'Admin\Menus\index',
            [
                'menus' => $this->Menus->findAllMenusWithTrees(),
                'articles' => $this->Articles->findAll(),
                'categories' => $this->Categories->findAll(),
                'validator' => $this->validator
            ]
        );
    }

    /**
     * add menu
     *
     * @throws \ReflectionException
     */
    public function add()
    {
        if ($this->request->isAJAX() && $this->request->getMethod() === 'POST') {
            $menu = new Menu();
            if ($this->validate(['name' => 'required'])) {
                $menu->fill($this->request->getJSON(true));
                if (($id = $this->Menus->insert($menu)) !== false) {
                    $menu = $this->Menus->find($id)->toArray();
                    $menu['children'] = [];
                    return response()->setJSON([
                        'message' => lang('admin.saved'),
                        'data' => $menu
                    ]);
                } else {
                    return response()->setStatusCode(422)->setJSON([
                        'errors' => ['any' => lang('admin.save_error')],
                        'data' => $menu->toArray()
                    ]);
                }
            } else {
                return response()->setStatusCode(422)->setJSON([
                    'errors' => $this->validator->getErrors()
                ]);
            }
        }

        throw new MethodNotAllowedException();
    }

    /**
     * edit menu
     *
     * @param null $id
     * @return ResponseInterface|string
     * @throws \ReflectionException
     */
    public function edit($id = null)
    {
        if ($this->request->isAJAX() && $this->request->getMethod() === 'POST') {
            $menu = $this->Menus->find($id);
            $post = $this->request->getJSON(true);

            if ($this->validate(['name' => 'required'])) {
                $menu->fill($post);
                try {
                    if ($this->Menus->save($menu)) {
                        return response()->setJSON([
                            'message' => lang('admin.saved'),
                            'data' => $menu->toArray()
                        ]);
                    } else {
                        return response()->setStatusCode(422)->setJSON([
                            'errors' => ['any' => lang('admin.save_error')],
                            'data' => $menu->toArray()
                        ]);
                    }
                } catch (\Exception $exception) {
                    return response()->setStatusCode(500)->setJSON([
                        'errors' => ['any' => $exception->getMessage()],
                        'data' => $menu->toArray()
                    ]);
                }
            } else {
                return response()->setStatusCode(422)->setJSON([
                    'errors' => $this->validator->getErrors(),
                    'data' => $post
                ]);
            }
        }

        throw new MethodNotAllowedException();
    }

    /**
     * delete menu
     * @param $id
     * @return ResponseInterface
     */
    public function delete($id)
    {
        if ($this->request->isAJAX()) {
            if ($this->Menus->delete($id)) {
                return response()->setJSON([
                    'message' => lang('admin.deleted')
                ]);
            } else {
                return response()->setStatusCode(500)
                    ->setJSON([
                        'message' => lang('admin.delete_error')
                    ]);
            }
        }

        throw new MethodNotAllowedException();
    }
}
