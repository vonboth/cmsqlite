<?php


namespace Admin\Controllers;


use Admin\Models\CategoriesModel;
use Admin\Models\Entities\Category;

/**
 * Class Categories
 * @package Admin\Controllers
 * @property CategoriesModel $Categories
 */
class Categories extends Base
{
    /** @var CategoriesModel $Categories */
    protected $Categories;

    /**
     * init controller
     */
    public function initialize()
    {
        $this->Categories = new CategoriesModel();
    }

    /**
     * index action / entry point
     * @return string
     */
    public function index()
    {
        return view(
            'Admin\Categories\index',
            ['categories' => $this->Categories->findAll()]
        );
    }

    /**
     * view item
     * @param null $id
     * @return string
     */
    public function view($id = null)
    {
        $category = $this->Categories->find($id);
        return view(
            'Admin\Categories\view',
            compact('category')
        );
    }

    /**
     * add new item
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \ReflectionException
     */
    public function add()
    {
        $category = new Category();

        if ($this->request->getMethod() === 'post') {
            if ($this->validate(['name' => 'required'])) {
                $category->fill($this->request->getPost());
                if ($lastId = $this->Categories->insert($category) !== false) {
                    return redirect()->to("/admin/categories/edit/$lastId")
                        ->with('flash', lang('General.saved'));
                } else {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('flash', lang('General.save_error'));
                }
            } else {
                return redirect()
                    ->back()
                    ->withInput();
            }
        }

        return view(
            'Admin\Categories\add',
            [
                'validator' => $this->validator,
                'category' => $category
            ]
        );
    }

    /**
     * edit / update item
     * @param null $id
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \ReflectionException
     */
    public function edit($id = null)
    {
        $category = $this->Categories->find($id);
        if ($this->request->getMethod() === 'post') {
            if ($this->validate(['name' => 'required'])) {
                $category->fill($this->request->getPost());
                try {
                    if ($this->Categories->save($category)) {
                        return redirect()
                            ->back()
                            ->with('flash', lang('General.saved'));
                    } else {
                        return redirect()
                            ->back()
                            ->withInput()
                            ->with('flash', lang('General.save_error'));
                    }
                } catch (\Exception $exception) {
                    return redirect()
                        ->back()
                        ->with('flash', $exception->getMessage());
                }
            } else {
                return redirect()
                    ->back()
                    ->withInput();
            }
        }

        return view(
            'Admin\Categories\edit',
            [
                'category' => $category,
                'validator' => $this->validator
            ]
        );
    }

    /**
     * delete item
     * @param $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($id)
    {
        if ($this->Categories->delete($id)) {
            return redirect()
                ->back()
                ->with('flash', lang('General.deleted'));
        } else {
            return redirect()
                ->back()
                ->with('flash', lang('General.delete_error'));
        }
    }
}