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
class CategoriesController extends BaseController
{
    /** @var CategoriesModel $Categories */
    protected CategoriesModel $Categories;

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
        return view(
            'Admin\Categories\view',
            [
                'category' => $this->Categories->find($id),
            ]
        );
    }

    /**
     * add new item
     * @return string|RedirectResponse
     * @throws \ReflectionException
     */
    public function add()
    {
        $category = new Category();

        if ($this->request->getMethod() === 'POST') {
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
                'category' => $category,
            ]
        );
    }

    /**
     * edit / update item
     *
     * @param null $id
     * @return string|RedirectResponse
     * @throws \ReflectionException
     */
    public function edit($id = null)
    {
        $category = $this->Categories->find($id);
        if ($this->request->getMethod() === 'POST') {
            if ($this->validate(['name' => 'required'])) {
                $category->fill($this->request->getPost());
                try {
                    if ($this->Categories->save($category)) {
                        return redirect()
                            ->to('/admin/categories/edit/' . $id)
                            ->with('flash', lang('General.saved'));
                    } else {
                        return redirect()
                            ->to('/admin/categories/edit/' . $id)
                            ->withInput()
                            ->with('flash', lang('General.save_error'));
                    }
                } catch (\Exception $exception) {
                    return redirect()
                        ->to('/admin/categories/edit/' . $id)
                        ->with('flash', $exception->getMessage());
                }
            } else {
                return redirect()
                    ->to('/admin/categories/edit/' . $id)
                    ->withInput();
            }
        }

        return view(
            'Admin\Categories\edit',
            [
                'category' => $category,
                'validator' => $this->validator,
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
