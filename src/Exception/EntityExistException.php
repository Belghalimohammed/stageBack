<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class EntityExistException extends HttpException
{
    public function __construct($message = null, $statusCode = 205, \Throwable $previous = null, array $headers = [], $code = 0)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}


