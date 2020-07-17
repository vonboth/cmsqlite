<?php


namespace Admin\Controllers;


use Admin\Models\CategoriesModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Categories
 * @package Admin\Controllers
 * @property CategoriesModel $Categories
 */
class Categories extends Base
{
    protected $Categories;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Categories = new CategoriesModel();
    }

    public function index()
    {
        /** @var  $query */
        $query = $this->db->table('categories')->get();

        return view(
            'Admin\Categories\index',
            ['categories' => $query->getResult()]
        );
    }

    public function view($id = null)
    {
        $category = $this->Categories->find($id);
        return view(
            'Admin\Categories\view',
            compact('category')
        );
    }

    public function add()
    {
        return view('Admin\Categories\add');
    }

    public function edit($id = null)
    {
        return view('Admin\Categories\edit');
    }

    public function delete($id)
    {
        return redirect('admin/categories');
    }
}