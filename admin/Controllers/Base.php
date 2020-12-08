<?php

namespace Admin\Controllers;

use Admin\Config\Validation;
use Admin\Services\AuthService;
use App\Controllers\Base as AppBase;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
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

    /** @var string $controllerName */
    protected string $controllerName = '';

    /** @var AuthService $AuthService */
    protected AuthService $AuthService;

    /** @var string $theme layout from config table */
    protected string $theme;

    /**
     * @inheritdoc
     */
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ): void {
        $this->validator = Services::validation(new Validation());
        $this->AuthService = service('auth');
        parent::initController($request, $response, $logger);

        $request->setLocale($this->SystemSettings->language);
        $this->theme = $this->SystemSettings->admin_theme;
        $this->View = Services::renderer();
        $this->controllerName = $this->parseControllerName();
        $this->View->setData(
            [
                'controller' => ($this->controllerName),
                'section' => lang("Tables.{$this->controllerName}.{$this->controllerName}"),
                'title' => 'CMSQLite',
                'theme' => $this->theme
            ]
        );

        $this->initialize();
    }

    /**
     * Initialize method to keep sub-controllers
     * signature cleaner
     */
    public function initialize(): void
    {
    }

    /**
     * parse controller name from request
     * @return string
     */
    protected function parseControllerName(): string
    {
        $router = Services::router();
        $namespace = '\\' . $router->getMatchedRouteOptions()['namespace'] . "\\";
        return strtolower(
            str_replace($namespace, '', $router->controllerName())
        );
    }
}