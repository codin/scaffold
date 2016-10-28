<?php 

namespace App\Controllers;

use Scaffold\Foundation\App;

/**
 * This class must be extended by your application controllers,
 * you should add any functionality here in which you wish to be
 * inherited by all of your application controllers.
 */
abstract class Controller
{
    protected $app;

    /**
     * Inject the app into the constructor
     * of the controllers.
     * 
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }
}