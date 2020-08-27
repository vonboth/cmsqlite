<?php

namespace App\Exceptions;

use CodeIgniter\Exceptions\ExceptionInterface;

class UnauthorizedException extends \RuntimeException implements ExceptionInterface
{
    protected $code = 401;
}