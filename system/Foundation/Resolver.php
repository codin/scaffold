<?php 

namespace Scaffold\Foundation;

use Scaffold\Exception\ControllerNotFoundException;
use Scaffold\Exception\MethodNotFoundException;
use Scaffold\Exception\NotFoundException;
use Scaffold\Foundation\App;
use Scaffold\Http\Response;

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
     * Actually resolve them
     * 
     * @return Scaffold\Http\Response
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

        $params = array_merge([
            container('request'),
            container('response'),
        ], $this->match);

        $response = call_user_func_array([$controller, $method], $params);

        if (!($response instanceof Response)) {
            throw new NotFoundException('Unable to determine response to return');
        }

        return $response;
    }
}
