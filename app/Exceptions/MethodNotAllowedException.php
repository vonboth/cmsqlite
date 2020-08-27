<?php

namespace App\Exceptions;

use CodeIgniter\Exceptions\ExceptionInterface;

class MethodNotAllowedException extends \RuntimeException implements ExceptionInterface
{
    protected $code = 405;
}