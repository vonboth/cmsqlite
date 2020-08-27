<?php

namespace App\Exceptions;

use CodeIgniter\Exceptions\ExceptionInterface;

class ForbiddenException extends \RuntimeException implements ExceptionInterface
{
    protected $code = 403;
}