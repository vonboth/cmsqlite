<?php


namespace Admin\Controllers;


use Admin\Models\Entities\Menu;
use Admin\Models\MenuitemsModel;
use Admin\Models\MenusModel;
use App\Models\ArticlesModel;
use CodeIgniter\API\ResponseTrait;
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
    use ResponseTrait;

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
        $menutrees = $this->Menus->findAllMenusWithTrees();
        $menus = $this->Menus->findAll();
        $articles = $this->Articles->findAll();

        return view(
            'Admin\Menus\index',
            [
                'menutrees' => $menutrees,
                'menus' => $menus,
                'articles' => $articles
            ]
        );
    }

    /**
     * @param null $id
     * @return string
     */
    public function view($id = null)
    {
        return redirect()->to('/admin/menus/index')
            ->with('flash', 'Not Implemented');
    }

    /**
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \ReflectionException
     */
    public function add()
    {
        $menu = new Menu();
        if ($this->request->getMethod() === 'post') {
            if ($this->validate(['name' => 'required'])) {
                $menu->fill($this->request->getPost());
                if ($lastId = $this->Menus->insert($menu) !== false) {
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
                    ->withInput();
            }
        }

        return redirect()
            ->to('/admin/menus/index')
            ->with('flash', 'Not Implemented');;
    }

    /**
     * @param null $id
     * @return string
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
                            ->withInput()
                            ->with('flash', lang('General.save_error'));
                    }
                } catch (\Exception $exception) {
                    return redirect()
                        ->to('/admin/menus/index')
                        ->withInput()
                        ->with('flash', $exception->getMessage());
                }
            } else {
                return redirect()
                    ->to('/admin/menus/index')
                    ->withInput();
            }
        }
        return redirect()
            ->to('/admin/menus/index')
            ->with('flash', 'Not Implemented');
    }

    /**
     * @param $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($id)
    {
        $menu = $this->Menus->find($id);
        if ($this->Menus->delete($id)) {
            if ($this->request->isAJAX()) {
                return $this->respondDeleted($menu, lang('General.deleted'));
            }
            return redirect()
                ->to('/admin/menus/index')
                ->with('flash', lang('General.deleted'));
        } else {
            if ($this->request->isAJAX()) {
                return $this->fail(lang('General.delete_error'));
            }
            return redirect()
                ->to('/admin/menus/index')
                ->with('flash', lang('General.delete_error'));
        }
    }
}