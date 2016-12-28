<?php 

namespace Scaffold\Http;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Scaffold's simple middleware wrapper around the
 * basic Relay package which uses PSR compliant
 * interfaces.
 */
abstract class Middleware
{
    /**
     * Invoke the middleware.
     * 
     * @param  Psr\Http\Message\RequestInterface  $request
     * @param  Psr\Http\Message\ResponseInterface $response
     * @param  callable $next
     * @return Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $this->intercept($request, $response, $next);

        return $response;
    }

    /**
     * This method must be defined by 
     * the application middleware.
     * 
     * @param  Psr\Http\Message\RequestInterface  $request
     * @param  Psr\Http\Message\ResponseInterface $response
     * @param  callable $next
     * @return Psr\Http\Message\ResponseInterface
     */
    public abstract function intercept(Request $request, Response $response, callable $next);
}