<?php

use Slim\App;
// use App\Controllers\TicketController;
use App\Actions\TicketAction;

return function (App $app) {
    // $app->get('/', TicketController::class . ':getTickets');
    $app->get('/action', TicketAction::class);

    // $container = $app->getContainer();

    // $app->get('/action/function', function ($request, $response, $args) use ($container) {
    //     var_dump($container); die();
    // });
};
