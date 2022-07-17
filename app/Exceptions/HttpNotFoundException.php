<?php

namespace App\Exceptions;

use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;

class HttpNotFoundException extends Exception
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $message;

    /**
     * @param Request
     * @param string
     */
    public function __construct($request, $message) {
        $this->request = $request;
        $this->message = $message;
    }
}
