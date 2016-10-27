<?php 

namespace Scaffold\Http;

use Scaffold\Exception\NotFoundException;
use Scaffold\Exception\UnsupportedMethodException;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class to register your application routes with,
 * bound to application service.
 */
class Router extends RouteCollection
{   

    /**
     * Handle calling get(), post(), put(), delete() etc 
     * on this router.
     * 
     * @param  string $method
     * @param  string $path
     * @param  array  $options
     * @return void
     *
     * @throws UnsupportedMethodException
     * @throws InvalidNumberOfArgumentsException
     */
    public function addRoute($method, $path, array $options)
    {
        if (!in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'])) {
            throw new UnsupportedMethodException($method);
        }

        $routeName = $options['name'];
        $options = ['controller' => $options['controller']];

        $route = new Route($path, $options, [], [], '', [], [strtoupper($method)]);
        $this->add($routeName, $route);
    }

    /**
     * Matches the routes setup by the user against 
     * the current request.
     * 
     * @return array
     */
    public function match(SymfonyRequest $request)
    {
        $context = new RequestContext('/');
        $path = $request->getPathInfo();

        $matcher = new UrlMatcher($this, $context);
        
        try {        
            return $matcher->match($path);
        } catch (ResourceNotFoundException $e) {
            throw new NotFoundException($path);
        }
    }
}