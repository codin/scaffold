<?php 

namespace App\Middleware;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Scaffold\Http\Middleware;

class NotAuthed extends Middleware
{
    /**
     * Intercept the request and only allow it to pass
     * if the request contains a non auth'd user.
     *
     * @param  Psr\Http\Message\RequestInterface $request
     * @param  Psr\Http\Message\ResponseInterface $response
     * @param  callable $next
     * @return Psr\Http\Message\ResponseInterface
     */
    public function intercept(Request $request, Response $response, callable $next)
    {
        $auth = auth();

        if ($auth->loggedIn()) {

            if ($auth->redirects()) {
                return response()->redirect($auth->getLoginRedirect());
            }

            return $response->withStatus(403, 'Unauthorized');
        }

        return $next($request, $response);
    }
}