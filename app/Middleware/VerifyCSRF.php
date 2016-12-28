<?php 

namespace App\Middleware;

use Scaffold\Http\Middleware;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * The CSRF middleware. This will check http
 * requests for the precense of a CSRF token to 
 * secure against CSRF attacks on form requests.
 */
class VerifyCSRF extends Middleware
{

    /**
     * Intercept the request and only allow it to pass
     * if the request contains a valid CSRF token.
     *
     * @param  Psr\Http\Message\RequestInterface $request
     * @param  Psr\Http\Message\ResponseInterface $response
     * @param  callable $next
     * @return Psr\Http\Message\ResponseInterface
     */
    public function intercept(Request $request, Response $response, callable $next)
    {
        if ($request->getMethod() == 'POST') {
            $body = $request->getParsedBody();

            $requested_token = false;
            $actual_token = 'testing';

            if (isset($body['_token'])) {
                $requested_token = $body['_token'];
            }

            if ($requested_token != $actual_token) {
                return $response->withStatus(403, 'Invalid CSRF token, request is unauthorized.');
            }
        }

        return $next($request, $response);
    }
}