<?php

namespace App\Errors;

use App\Interfaces\ErrorInterface;
use Psr\Http\Message\RequestInterface as Request;
use App\Interfaces\ResponseInterfaceApplication as Response;
use Exception;

class ErrorsHandlerApplication implements ErrorInterface
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $type;
    
    /**
     * @var string
     */
    private $description;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;
    
    /**
     * @var Exception
     */
    private $exception;

    /**
     * @var array
     */
    private $methods;

    /**
     * @param Request $request
     * @param Response $response
     * @param Exception $exception
     * @param String $errorType
     * @param array $methods
     */
    public function __construct($request, $response, $exception, $errorType = null, $methods = [])
    {
        $this->request = $request;
        $this->response = $response;
        $this->exception = $exception;
        $this->type = $errorType;
        $this->methods = $methods;

        // Treat and get information
        $this->treatInformationError();
    }

    /**
     * Return status code from error
     * 
     * @return int
     */
    public function treatInformationError()
    {
        $status = 0;
        $description = '';

        switch ($this->getType()) {
            case 'errorHandler':
                $status = 500;
                $description = $this->exception->getMessage();
                break;
            case 'notFoundHandler':
                $status = 404;
                $description = 'Page not found';
                break;
            case 'notAllowedHandler':
                $status = 405;
                $description = 'Method must be one of: ' . implode(', ', $this->methods);
                break;
            case 'phpErrorHandler':
                $status = 500;
                $description = $this->exception->getMessage();
                break;
            default:
                $status = 500;
                $description = $this->exception->getMessage();
                break;
        }

        $this->statusCode = $status;
        $this->description = $description;
    }

    /**
     * Return status code from error
     * 
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Return error type
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Return description of error
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Response
     */
    public function respond()
    {
        $error = [
            'statusCode' => $this->getStatusCode(),
            'error' => [
                'type' => $this->getType(),
                'description' => $this->getDescription(),
            ],
        ];


        if (!is_null($this->methods)) {
            $this->response->withHeader('Allow', implode(', ', $this->methods));
        }

        return $this->response->withJson(
            $error,
            $this->getStatusCode(),
            JSON_PRETTY_PRINT
        );
    }
}
