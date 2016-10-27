<?php 

namespace Scaffold\Foundation;

use Dotenv\Dotenv;
use Scaffold\Http\Request;
use Scaffold\Http\Response;
use Scaffold\Http\Router;
use Symfony\Component\DependencyInjection\ContainerBuilder;


/**
 * The primary application class in Scaffold
 */
class App
{
    /**
     * The dependency injection container
     * 
     * @var ContainerBuilder
     */
    public $container;

    /**
     * Do stuff when we boot the app up.
     */
    public function __construct($root)
    {
        // Load in environment variables from ".env"
        $dotenv = new Dotenv($root);
        $dotenv->load();

        $this->container = new ContainerBuilder();

        $this->bind('request', new Request());
        $this->bind('response', new Response());

        $this->bind('router', new Router());
    }

    /**
     * Bind a service to the App container
     * 
     * @param  string $service
     * @param  Object $instance
     * @return Object
     */
    public function bind($service, $instance)
    {   
        $this->container->set($service, $instance);
    }

    /**
     * Get a service from the App container
     * 
     * @param  string $service
     * @return Object
     */
    public function get($service)
    {
        return $this->container->get($service);
    }

    public function matchRoutes()
    {
        $matches = $this->get('router')->match($this->get('request'));
        dd($matches);
    }

    /**
     * Render our applications response
     * 
     * @return void
     */
    public function render()
    {
        $this->get('response')->prepare($this->get('request'))->send();
    }
}