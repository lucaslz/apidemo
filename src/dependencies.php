<?php

use Slim\App;
use App\Errors\ErrorsHandlerApplication;
// use Illuminate\Database\Capsule\Manager;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    // Erros gerais no formato json
    $container['errorHandler'] = function ($c) {
        return function ($request, $response, $exception) use ($c) {
            $errorsHandlerApplication = new ErrorsHandlerApplication($request, $response, $exception, 'errorHandler');
            return $errorsHandlerApplication->respond();
        };
    };

    // Erros 404 no formato json
    $container['notFoundHandler'] = function ($c) {
        return function ($request, $response) use ($c) {
            $errorsHandlerApplication = new ErrorsHandlerApplication($request, $response, null, 'notFoundHandler');
            return $errorsHandlerApplication->respond();
        };
    };

    // Erros de falta de permissao no formato json
    $container['notAllowedHandler'] = function ($c) {
        return function ($request, $response, $methods) use ($c) {
            $errorsHandlerApplication = new ErrorsHandlerApplication($request, $response, null, 'notAllowedHandler', $methods);
            return $errorsHandlerApplication->respond();
        };
    };

    // Erros da aplicacao no formato json
    $container['phpErrorHandler'] = function ($c) {
        return function ($request, $response, $exception) use ($c) {
            $errorsHandlerApplication = new ErrorsHandlerApplication($request, $response, $exception, 'phpErrorHandler');
            return $errorsHandlerApplication->respond();
        };
    };
};
