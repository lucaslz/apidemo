<?php

namespace App\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface ResponseInterfaceApplication extends ResponseInterface
{

    /**
     * Json.
     *
     * Note: This method is not part of the PSR-7 standard.
     *
     * This method prepares the response object to return an HTTP Json
     * response to the client.
     *
     * @param  mixed $data   The data
     * @param  int   $status The HTTP status code.
     * @param  int   $encodingOptions Json encoding options
     *
     * @return static
     *
     * @throws RuntimeException
     */
    public function withJson($data, $status = null, $encodingOptions = 0);
}