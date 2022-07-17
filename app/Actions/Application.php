<?php

namespace App\Actions;

use App\Exceptions\HttpNotFoundException;
use App\Exceptions\HttpBadRequestException;
use App\Exceptions\DomainRecordNotFoundException;
use App\Interfaces\ResponseInterfaceApplication as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use App\Exceptions\InvalidArgumentException;
use App\Actions\ActionPayload;

abstract class Application
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Request
     */
    private $request;
    
    /**
     * @var Response
     */
    private $response;
    
    /**
     * @var array
     */
    private $args;

    /**
     * @param ContainerInterface $container
     */
    public function __construct($container = []) {

        if (!$container instanceof ContainerInterface) {
            throw new InvalidArgumentException('Expected a ContainerInterface');
        }

        $this->container = $container;
    }

    /**
     * @throws HttpNotFoundException
     * @throws HttpBadRequestException
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function __invoke($request, $response, $args)
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        try {
            return $this->action();
        } catch (DomainRecordNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

   /**
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     * 
     * @return Response
     */
    protected function action()
    {
        $method = '';

        switch ($this->getCurrentMethodRequest()) {
            case 'GET':
                if ($this->methodGetIsParam()) {
                    $method = 'show'; 
                }else {
                    $method = 'index';
                }
                break;
            case 'POST':
                $method = 'store';
                break;
            case 'PUT':
                $method = 'update';
                break;
            case 'PATCH':
                $method = 'update';
                break;
            case 'DELETE':
                $method = 'destroy';
                break;            
            default:
                throw new HttpNotFoundException($this->request, "method '" . $this->getCurrentMethodRequest() . "' not implemented.");
                break;
        }

        return $this->$method();
    }

    /**
     * @return boolean
     */
    protected function methodGetIsParam()
    {
        return (is_array($this->getArgs()) && count($this->getArgs()) > 0);
    }

    /**
     * Get the value of container
     *
     * @return  ContainerInterface
     */ 
    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * Get the value of request
     *
     * @return  Request
     */ 
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * Get the value of response
     *
     * @return  Response
     */ 
    protected function getResponse()
    {
        return $this->response;
    }

    /**
     * Get the value of args
     *
     * @return  array
     */ 
    protected function getArgs()
    {
        return $this->args;
    }

    /**
     * Get the value of currentMethodRequest
     *
     * @return  string
     */
    protected function getCurrentMethodRequest()
    {
        return $this->getRequest()->getMethod();
    }

    /**
     * Get the value of queryParams
     *
     * @return  array
     */
    protected function getQueryParams()
    {
        return $this->getRequest()->getQueryParams();
    }

    /**
     * Get the value of body formData
     *
     * @return array
     */
    protected function getFormData()
    {
        return $this->getRequest()->getParsedBody();
    }

    /**
     * @return mixed
     * @throws HttpBadRequestException
     */
    protected function resolveArg(string $name)
    {
        if (!isset($this->args[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name];
    }

    /**
     * @param array|object|null $data
     * @param int $statusCode
     * 
     * @return Response
     */
    protected function respondWithData($data = null, $statusCode = 200)
    {
        $payload = new ActionPayload($statusCode, $data);
        return $this->response->withJson($payload, $statusCode, JSON_PRETTY_PRINT);
    }
}
