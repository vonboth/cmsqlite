<?php


namespace Admin\Controllers;


use Admin\Models\MenuitemsModel;
use Admin\Models\MenusModel;
use App\Models\ArticlesModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Articles
 * @package Admin\Controllers
 * @property MenusModel $Menus
 * @property MenuitemsModel $Menuitems
 * @property ArticlesModel $Articles
 */
class Menus extends Base
{
    protected $Menus;
    protected $Menuitems;
    protected $Articles;

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->Menus = new MenusModel();
        $this->Menuitems = new MenuitemsModel();
        $this->Articles = new ArticlesModel();
    }

    /**
     * @return string
     */
    public function index()
    {
        $menus = $this->Menus->findAllMenusWithTrees();
        //var_dump($menus);exit;
        $menuitems = $this->Menuitems
            ->orderBy('lft')
            ->findAll();
        $artciles = $this->Articles->findAll();

        return view(
            'Admin\Menus\index',
            [
                'menus' => $menus,
                'menuitems' => $menuitems,
                'articles' => $artciles
            ]
        );
    }

    public function view($id = null)
    {
    }

    public function add()
    {
    }

    public function edit($id = null)
    {
    }

    public function delete($id)
    {
        if ($this->Menus->delete($id)) {
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