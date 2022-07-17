<?php
namespace App\Handlers;

// use Psr\Http\Message\ResponseInterface;
// use Slim\Exception\HttpBadRequestException;
// use Slim\Exception\HttpException;
// use Slim\Exception\HttpForbiddenException;
// use Slim\Exception\HttpMethodNotAllowedException;
// use Slim\Exception\HttpNotFoundException;
// use Slim\Exception\HttpNotImplementedException;
// use Slim\Exception\HttpUnauthorizedException;
use Slim\Handlers\Error;
// use Exception;
// use Throwable;

class HttpErrorHandler extends Error
{
    const BAD_REQUEST = 'BAD_REQUEST';
    const INSUFFICIENT_PRIVILEGES = 'INSUFFICIENT_PRIVILEGES';
    const NOT_ALLOWED = 'NOT_ALLOWED';
    const NOT_IMPLEMENTED = 'NOT_IMPLEMENTED';
    const RESOURCE_NOT_FOUND = 'RESOURCE_NOT_FOUND';
    const SERVER_ERROR = 'SERVER_ERROR';
    const UNAUTHENTICATED = 'UNAUTHENTICATED';
    
    /**
     * @return ResponseInterface
     */
    protected function respond()
    {
        $exception = $this->exception;
        $statusCode = 500;
        $type = self::SERVER_ERROR;
        $description = 'An internal error has occurred while processing your request.';

    //     if ($exception instanceof HttpException) {
    //         $statusCode = $exception->getCode();
    //         $description = $exception->getMessage();

    //         if ($exception instanceof HttpNotFoundException) {
    //             $type = self::RESOURCE_NOT_FOUND;
    //         } elseif ($exception instanceof HttpMethodNotAllowedException) {
    //             $type = self::NOT_ALLOWED;
    //         } elseif ($exception instanceof HttpUnauthorizedException) {
    //             $type = self::UNAUTHENTICATED;
    //         } elseif ($exception instanceof HttpForbiddenException) {
    //             $type = self::UNAUTHENTICATED;
    //         } elseif ($exception instanceof HttpBadRequestException) {
    //             $type = self::BAD_REQUEST;
    //         } elseif ($exception instanceof HttpNotImplementedException) {
    //             $type = self::NOT_IMPLEMENTED;
    //         }
    //     }

    //     if (
    //         !($exception instanceof HttpException)
    //         && ($exception instanceof Exception || $exception instanceof Throwable)
    //         && $this->displayErrorDetails
    //     ) {
    //         $description = $exception->getMessage();
    //     }

    //     $error = [
    //         'statusCode' => $statusCode,
    //         'error' => [
    //             'type' => $type,
    //             'description' => $description,
    //         ],
    //     ];
        
    //     $payload = json_encode($error, JSON_PRETTY_PRINT);
        
    //     $response = $this->responseFactory->createResponse($statusCode);        
    //     $response->getBody()->write($payload);
        
    //     return $response;
    }
}
