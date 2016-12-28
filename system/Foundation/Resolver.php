<?php 

namespace Scaffold\Foundation;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Relay\RelayBuilder;
use Scaffold\Exception\ControllerNotFoundException;
use Scaffold\Exception\MethodNotFoundException;
use Scaffold\Exception\NotFoundException;
use Scaffold\Foundation\App;
use Scaffold\Http\Response;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;

/**
 * Resolve our routes from our URL matches,
 * execute the methods and pass in any parameters
 * to the controllers that we need.
 */
class Resolver
{
    /**
     * The name of the controller
     * 
     * @var string
     */
    private $controller;

    /**
     * The name of the method
     * 
     * @var string
     */
    private $method;

    /**
     * Construc the resolver with the route match
     * data. So we can set things on this instance.
     * 
     * @param array $match
     */
    public function __construct($match)
    {
        $this->match = $match;

        $parts = explode('@', $this->match['controller']);

        if (!is_array($parts) || count($parts) != 2) {
            throw new ControllerNotFoundException('Unable to parse controller from routing configuration.');
        }

        list($this->controller, $this->method) = $parts;

        if (!class_exists($this->controller)) {
            throw new ControllerNotFoundException($this->controller);
        }
    }

    /**
     * Given our controller and method, create a new instance. Fetch
     * all middleware that this controller will be using and push
     * middleware into our Relay instance, this will determine the
     * response this resolution will provide.
     * 
     * @return Psr\Http\Message\ResponseInterface
     */
    public function resolve()
    {
        $controller = $this->controller;
        $method = $this->method;

        $controller = new $controller();

        if (!method_exists($controller, $method)) {
            throw new MethodNotFoundException($controller, $method);
        }

        unset($this->match['controller']);
        unset($this->match['_route']);

        $params = $this->match;

        return $this->processMiddleware($controller, $method, $params);
    }

    /**
     * Given the controller, method and it's parameters, we shall
     * process our application middleware so that we can modify
     * the request and return the correct response appropriately.
     * 
     * @param  App\Controllers\Controller $controller
     * @param  string $method
     * @param  array $params
     * @return Psr\Http\Message\ResponseInterface
     */
    private function processMiddleware($controller, $method, $params)
    {
        $psrFactory = new DiactorosFactory();
        $httpFoundationFactory = new HttpFoundationFactory();

        $queue = $controller->middleware();
        $queue[] = function (RequestInterface $request, ResponseInterface $response, callable $next) use ($controller, $method, $params, $psrFactory) {
            $response = call_user_func_array([$controller, $method], $params); 

            if (!($response instanceof Response)) {
                throw new NotFoundException('Unable to determine response to return');
            }

            return $psrFactory->createResponse($response);
        };

        $relayBuilder = new RelayBuilder();
        $relay = $relayBuilder->newInstance($queue);

        $psrResponse = $relay(
            $psrFactory->createRequest(request()), 
            $psrFactory->createResponse(response())
        );

        return $httpFoundationFactory->createResponse($psrResponse);
    }
}
