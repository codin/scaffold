<?php 

namespace Scaffold\Foundation;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Our application container
 */
class Container extends ContainerBuilder
{

    /**
     * Hold the singleton instance
     * 
     * @var Symfony\Component\DependencyInjection\ContainerBuilder
     */
    public static $instance;

    /**
     * Retrieve the instance of this container
     * 
     * @return Container
     */
    public static function getInstance() : Container
    {
        if (!static::$instance) {
            static::$instance = new Container();
        }

        return static::$instance;
    }

    /**
     * Bind a service to the App container
     * 
     * @param  string $service
     * @param  Object $instance
     * @return Container
     */
    public function bind($service, $instance) : Container
    {   
        $this->set($service, $instance);

        return $this;
    }
}