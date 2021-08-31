<?php

namespace Admin\Controllers;

use Admin\Config\Validation;
use Admin\Services\AuthService;
use App\Controllers\BaseController as AppBase;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Psr\Log\LoggerInterface;

/**
 * Class Base
 * @package Admin\Controllers
 * TODO: INSTALLATION ROUTINE: EMAIL SETTINGS ...
 */
class BaseController extends AppBase
{
    /** @var array $helpers Helpers to load */
    protected $helpers = ['html', 'form', 'Admin\Helpers\tree_helper', 'inflector', 'filesystem', 'format'];

    /** @var string $controllerName */
    protected string $controllerName = '';

    /** @var AuthService $AuthService */
    protected AuthService $AuthService;

    /** @var string $theme layout from config table */
    protected string $theme;

    /** @var string $version current CMSQLite version */
    protected string $version;

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
                'theme' => $this->theme,
                'version' => $this->_getVersion(),
                'editor_style' => $this->SystemSettings->editor_style
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

    /**
     * Strip the current version from composer
     * @return string
     */
    private function _getVersion(): string
    {
        $composer = json_decode(file_get_contents(ROOTPATH . 'composer.json'));
        $this->version = $composer->version;
        return $this->version;
    }
}