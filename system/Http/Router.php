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
     * The resource methods with matching names
     * and route patterns.
     * 
     * @var array
     */
    private static $resource_methods = [
        'create' => ['POST', '/'],
        'read'   => ['GET', '/{id}'],
        'update' => ['PUT', '/{id}'],
        'delete' => ['DELETE', '/{id}'],
    ];

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
    public function route($method, $path, array $options)
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
     * Add a resource route using CRUD/REST
     * endpoint patterns and request methods.
     *
     * Can optionally pass array of names, first index
     * is used as singular, second as plural.
     *
     * @param  string|array $name
     * @param  array        $allowed
     * @param  string       $namespace
     */
    public function resource($name, $allowed = ['create', 'read', 'update', 'delete'], $namespace = '\App\Controllers')
    {
        $methods = [];

        foreach ($allowed as $allowed_method) {
            if (isset(static::$resource_methods[$allowed_method])) {
                $methods[$allowed_method] = static::$resource_methods[$allowed_method];
            }
        }

        $singular = $name;
        $plural = $name;

        if (is_array($name) && count($name) >= 2) {
            $singular = $name[0];
            $plural   = $name[1];
        }

        foreach ($methods as $type => $route) {
            $url = '/' . $plural . $route[1];
            $route_name = join(', ', [strtolower($singular), $type]);
            $controller = trim(ucfirst($plural));

            $this->route($route[0], $url, [
                'name'       => $route_name,
                'controller' => $namespace . '\\' . $controller .'Controller@' . $type,
            ]);
        }
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
