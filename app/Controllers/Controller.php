<?php 

namespace App\Controllers;

use App\Middleware\VerifyCSRF;

/**
 * This class must be extended by your application controllers,
 * you should add any functionality here in which you wish to be
 * inherited by all of your application controllers.
 */
abstract class Controller
{
    /**
     * Add middleware to this array on your
     * controllers so that they can make use
     * of custom middleware.
     * 
     * @var array
     */
    protected $middleware = [];

    /**
     * Get the global request middleware and merge
     * them with the controller specific middleware.
     * 
     * @return array
     */
    public function middleware()
    {
        return array_merge([

            // CSRF Middleware for all controller actions.
            'csrf' => new VerifyCSRF,
            
        ], $this->middleware);
    }
}