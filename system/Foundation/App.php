<?php 

namespace Scaffold\Foundation;

use Dotenv\Dotenv;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Scaffold\Foundation\Resolver;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

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
     * Store the listener instances
     * 
     * @var array
     */
    private $listeners = [];

    /**
     * The paths for this application
     * 
     * @var array
     */
    private $paths = [];

    /**
     * Do stuff when we boot the app up.
     */
    public function __construct($root, $services = [])
    {
        $this->setupInitialPaths($root);

        $this->container = container();
        $this->container->set('app', $this);

        foreach ($services as $name => $service) {
            $this->container->bind($name, $service);
        }

        if ($this->container->has('stopwatch')) { 
            $this->container->get('stopwatch')->start('application');
        }

        $this->container->get('config')->loadConfigurationFiles(
            $this->paths['config_path'],
            $this->getEnvironment()
        );

        $this->setupConfigurablePaths($root);
            
        if ($this->container->has('logger')) {        
            $this->container->get('logger')->pushHandler(new StreamHandler($this->paths['log_file'], Logger::WARNING));
        }

        $this->bindEventListeners();

        if ($this->container->has('templater')) {
            $templater = $this->container->get('templater');
            
            $templater->addEngine(new PhpEngine(
                new TemplateNameParser(), 
                new FilesystemLoader($this->paths['view_path'])
            ));
        }

        if ($this->container->has('database')) {
            $database = $this->container->get('database');
            $database->addConnection($this->container->get('config')->get('database.default'));
            $database->setAsGlobal();
            $database->bootEloquent();
        }
    }

    /**
     * Bind the application event listeners given the
     * event configuration.
     * 
     * @return void
     */
    private function bindEventListeners()
    {
        if (!$this->container->has('dispatcher')) {
            return;
        }

        $dispatcher = $this->container->get('dispatcher');
        $config = $this->container->get('config')->get('events');

        $listeners = $config['listeners'];

        foreach ($listeners as $listener) {
            $listener = new $listener;

            foreach ($listener->getEvents() as $event => $method) {
                $dispatcher->addListener($event, [$listener, $method]);
            }

            $this->listeners[] = $listener;
        }
    }

    /**
     * Initialize the paths.
     *
     * @param  string $root
     * @return void
     */
    private function setupInitialPaths($root)
    {
        $this->paths['env_file_path'] = $root;
        $this->paths['env_file']      = $this->paths['env_file_path'].'.env';
        $this->paths['config_path']   = $root . '/config';
    }

    /**
     * Setup our configurable paths.
     * 
     * @param  string $root
     * @return void
     */
    private function setupConfigurablePaths($root)
    {
        $config = $this->container->get('config');

        $this->paths['log_file']    = $root . $config->get('app.log_file');
        $this->paths['view_path']   = $root . $config->get('templating.view_path');
        $this->paths['module_path'] = $config->get('templating.module_path');
        $this->paths['cache_path']  = $root . $config->get('app.cache_path');
        $this->paths['storage_path'] = $root . $config->get('app.storage_path');
    }

    /**
     * Match the application routes with the request
     * 
     * @return void
     */
    public function matchRoutes()
    {
        $match = $this->container->get('router')->match($this->container->get('request'));
        $resolver = new Resolver($match);

        $this->container->bind('response', $resolver->resolve());
    }

    /**
     * Render our applications response
     * 
     * @return void
     */
    public function render()
    {
        $response = $this->container->get('response');
        $response->prepare($this->container->get('request'));
        
        $content = $response->getContent();

        if ($this->container->has('stopwatch')) {
            $this->profile = $this->container->get('stopwatch')->stop('application');
            $memory = human_file_size($this->profile->getMemory(), 'MB');
            $time = $this->profile->getDuration() . 'ms';
            $this->profile = 'memory=' . $memory . '; time=' . $time . ';';
            $response->headers->set('X-Scaffold-Profiling', $this->profile);

            $content = $content . '<script>var profile = ' . json_encode(compact('memory', 'time')) . '; // Profiling information </script>';
        }

        $response->setContent($content)->send();
    }

    /**
     * Detect the environment. Defaults to `production`.
     *
     * @return string
     */
    public function getEnvironment()
    {
        if (is_file($this->paths['env_file'])) {
            $dotenv = new Dotenv($this->paths['env_file_path']);
            $dotenv->load();
        }

        return env('ENVIRONMENT') ?: 'production';
    }

    /**
     * Get the application paths
     * 
     * @return array
     */
    public function getPaths()
    {
        return $this->paths;
    }
}