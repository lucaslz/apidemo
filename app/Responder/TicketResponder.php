<?php

namespace App\Responder;

use Psr\Http\Message\ResponseInterface as Response;

class TicketResponder
{
    public function index(Response $response, array $data)
    {
        return $response->withJson($data);
    }
}