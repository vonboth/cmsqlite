<?php

namespace Admin\Controllers;

use Admin\Config\Validation;
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

    /**
     * @inheritdoc
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->validator = Services::validation(new Validation());
        parent::initController($request, $response, $logger);
        $this->view = Services::renderer();
        helper(['form', 'Admin\Helpers\tree_helper']);
        $this->controllerName = $request->uri->getSegment(2);
        $this->view->setData(
            [
                'controller' => $this->controllerName,
                'section' => lang("Tables.{$this->controllerName}.{$this->controllerName}")
            ]
        );
    }
}