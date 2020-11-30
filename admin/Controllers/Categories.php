<?php


namespace Admin\Controllers;


use Admin\Models\CategoriesModel;
use Admin\Models\Entities\Category;
use CodeIgniter\HTTP\RedirectResponse;

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
    public function initialize(): void
    {
        $this->Categories = new CategoriesModel();
    }

    /**
     * index action / entry point
     * @return string
     */
    public function index(): string
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
    public function view($id = null): string
    {
        $category = $this->Categories->find($id);
        return view(
            'Admin\Categories\view',
            compact('category')
        );
    }

    /**
     * add new item
     *
     * @return string
     *
     * @throws \ReflectionException
     */
    public function add(): string
    {
        $category = new Category();

        if ($this->request->getMethod() === 'post') {
            if ($this->validate(['name' => 'required'])) {
                $category->fill($this->request->getPost());
                if ($this->Categories->insert($category) !== false) {
                    return redirect()
                        ->to('/admin/categories/edit/' . $this->Categories->getInsertID())
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
     *
     * @param null $id
     *
     * @return string
     *
     * @throws \ReflectionException
     */
    public function edit($id = null): string
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
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
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