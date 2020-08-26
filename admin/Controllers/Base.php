<?php

namespace Admin\Controllers;

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
 */
class Base extends AppBase
{
    /** @var null|View $view */
    protected $view = null;

    /** @var string $controllerName */
    protected $controllerName = '';

    /** @var AuthService $AuthService */
    protected $AuthService;

    /**
     * @inheritdoc
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->validator = Services::validation(new Validation());
        $this->AuthService = service('auth');
        parent::initController($request, $response, $logger);
        $this->view = Services::renderer();
        helper(['form', 'Admin\Helpers\tree_helper', 'inflector']);
        $this->controllerName = $this->parseControllerName();
        $this->view->setData(
            [
                'controller' => ($this->controllerName),
                'section' => lang("Tables.{$this->controllerName}.{$this->controllerName}"),
                'title' => 'CMSQLite'
            ]
        );
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