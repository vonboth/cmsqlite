<?php

namespace Admin\Controllers;

use Admin\Config\Validation;
use App\Controllers\Base as AppBase;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Psr\Log\LoggerInterface;

/**
 * Class Base
 * @package Admin\Controllers
 */
class Base extends AppBase
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->validator = Services::validation(new Validation());
        parent::initController($request, $response, $logger);
        helper(['form']);
    }
}