<?php 

namespace Scaffold\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        return $this->intercept($request, $response, $next);
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
    public abstract function intercept(RequestInterface $request, ResponseInterface $response, callable $next);
}