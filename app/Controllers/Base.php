<?php

namespace App\Controllers;

use Admin\Models\MenuitemsModel;
use Admin\Models\MenusModel;
use Admin\Models\ArticlesModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\View\RendererInterface;
use Config\Services;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @property ArticlesModel $Articles
 * @property MenusModel $Menus
 * @property MenuitemsModel $Menuitems
 */
class Base extends Controller
{
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['html', 'form', 'format', 'Admin\Helpers\tree_helper'];

    /** @var $session */
    protected $session;

    /** @var ArticlesModel $Articles */
    protected $Articles;

    /** @var MenusModel $Menus */
    protected $Menus;

    /** @var MenuitemsModel $Menuitems */
    protected $Menuitems;

    /** @var RendererInterface $View */
    protected $View;

    /**
     * @inheritdoc
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = Services::session();

        $this->Articles = new ArticlesModel();
        $this->Menuitems = new MenuitemsModel();
        $this->Menus = new MenusModel();
        $this->View = Services::renderer();
    }
}
