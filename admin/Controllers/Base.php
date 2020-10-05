<?php

namespace Admin\Controllers;

use Admin\Config\SystemSettings;
use Admin\Config\Validation;
use Admin\Services\AuthService;
use App\Controllers\Base as AppBase;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\View\View;
use Config\Services;
use Psr\Log\LoggerInterface;

/**
 * Class Base
 * @package Admin\Controllers
 * TODO: INSTALLATION ROUTINE WITH: ADMIN PASS, EMAIL SETTINGS, FOLDER CHECK, ...
 */
class Base extends AppBase
{
    /** @var array $helpers Helpers to load */
    protected $helpers = ['html', 'form', 'Admin\Helpers\tree_helper', 'inflector', 'filesystem', 'format'];

    /** @var SystemSettings|null $SystemSettings */
    protected ?SystemSettings $SystemSettings = null;

    /** @var null|View $view */
    protected ?View $view = null;

    /** @var string $controllerName */
    protected string $controllerName = '';

    /** @var AuthService $AuthService */
    protected AuthService $AuthService;

    /**
     * @inheritdoc
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->validator = Services::validation(new Validation());
        $this->AuthService = service('auth');
        parent::initController($request, $response, $logger);

        $this->SystemSettings = config('Admin\Config\SystemSettings');
        $this->view = Services::renderer();
        $this->controllerName = $this->parseControllerName();
        $this->view->setData(
            [
                'controller' => ($this->controllerName),
                'section' => lang("Tables.{$this->controllerName}.{$this->controllerName}"),
                'title' => 'CMSQLite'
            ]
        );

        $this->initialize();
    }

    /**
     * Initialize method to keep sub-controllers
     * signature cleaner
     */
    public function initialize()
    {
    }

    /**
     * parse controller name from request
     * @return string
     */
    protected function parseControllerName()
    {
        $router = Services::router();
        $namespace = '\\' . $router->getMatchedRouteOptions()['namespace'] . "\\";
        return strtolower(
            str_replace($namespace, '', $router->controllerName())
        );
    }
}