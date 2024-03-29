<?php


namespace Admin\Controllers;


use Admin\Models\ArticlesModel;
use Admin\Models\CategoriesModel;
use Admin\Models\Entities\Menu;
use Admin\Models\MenuitemsModel;
use Admin\Models\MenusModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Class Articles
 * @package Admin\Controllers
 * @property MenusModel $Menus
 * @property MenuitemsModel $Menuitems
 * @property ArticlesModel $Articles
 * @property CategoriesModel $Categories
 */
class MenusController extends BaseController
{
    /** @var MenusModel $Menus */
    protected $Menus;

    /** @var MenuitemsModel $Menuitems */
    protected $Menuitems;

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
        $this->Menuitems = new MenuitemsModel();
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
                'menutrees' => $this->Menus->findAllMenusWithTrees(),
                'menus' => $this->Menus->findAll(),
                'menuitems' => $this->Menuitems->findAll(),
                'articles' => $this->Articles->findAll(),
                'categories' => $this->Categories->findAll(),
                'validator' => $this->validator
            ]
        );
    }

    /**
     * add menu
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \ReflectionException
     */
    public function add()
    {
        $menu = new Menu();
        if ($this->request->getMethod() === 'post') {
            if ($this->validate(['name' => 'required'])) {
                $menu->fill($this->request->getPost());
                if ($this->Menus->insert($menu) !== false) {
                    return redirect()
                        ->to('/admin/menus/index')
                        ->with('flash', lang('General.saved'));
                } else {
                    return redirect()
                        ->to('/admin/menus/index')
                        ->withInput()
                        ->with('flash', lang('General.save_error'));
                }
            } else {
                return redirect()
                    ->to('/admin/menus/index')
                    ->with('flash', $this->validator->getErrors())
                    ->with('_ci_validation_errors', $this->validator->getErrors());
            }
        }

        return redirect()
            ->to('/admin/menus/index')
            ->with('flash', 'Not Implemented');
    }

    /**
     * edit menu
     *
     * @param null $id
     * @return RedirectResponse|string
     * @throws \ReflectionException
     */
    public function edit($id = null)
    {
        $menu = $this->Menus->find($id);
        if ($this->request->getMethod() === 'post') {
            if ($this->validate(['name' => 'required'])) {
                $menu->fill($this->request->getPost());
                try {
                    if ($this->Menus->save($menu)) {
                        return redirect()
                            ->to('/admin/menus/index')
                            ->with('flash', lang('General.saved'));
                    } else {
                        return redirect()
                            ->to('/admin/menus/index')
                            ->with('flash', lang('General.save_error'));
                    }
                } catch (\Exception $exception) {
                    return redirect()
                        ->to('/admin/menus/index')
                        ->with('flash', $exception->getMessage());
                }
            } else {
                return redirect()
                    ->to('/admin/menus/index')
                    ->with('flash', $this->validator->getErrors())
                    ->with('_ci_validation_errors', $this->validator->getErrors());
            }
        }
        return redirect()
            ->to('/admin/menus/index');
    }

    /**
     * delete menu
     * @param $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($id)
    {
        if ($this->Menus->delete($id)) {
            return redirect()
                ->to('/admin/menus/index')
                ->with('flash', lang('General.deleted'));
        } else {
            return redirect()
                ->to('/admin/menus/index')
                ->with('flash', lang('General.delete_error'));
        }
    }
}
