<?php

namespace App\Controllers;

use Admin\Config\SystemSettings;
use Admin\Models\ArticlesModel;
use Admin\Models\MenuitemsModel;
use Admin\Models\MenusModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\Session;
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
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [
        'html',
        'form',
        'format',
        'Admin\Helpers\tree_helper',
        'App\Helpers\content_helper'
    ];

    /** @var Session $session */
    protected Session $session;

    /** @var ArticlesModel $Articles */
    protected $Articles;

    /** @var MenusModel $Menus */
    protected $Menus;

    /** @var MenuitemsModel $Menuitems */
    protected $Menuitems;

    /** @var SystemSettings|null $SystemSettings */
    protected ?SystemSettings $SystemSettings = null;

    /** @var mixed|null|string $theme default theme from config */
    protected string $theme;

    /** @var RendererInterface $View */
    protected RendererInterface $View;

    /**
     * @inheritdoc
     */
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);

        $this->session = Services::session();

        $this->SystemSettings = config('Admin\Config\SystemSettings');
        $this->Articles = new ArticlesModel();
        $this->Menuitems = new MenuitemsModel();
        $this->Menus = new MenusModel();
        $this->theme = $this->SystemSettings->theme;
        $this->View = Services::renderer();

        $this->View->setData(
            [
                'layout' => $this->theme
            ]
        );
    }
}
