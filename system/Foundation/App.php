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
     * Do stuff when we boot the app up.
     */
    public function __construct($root, $services = [])
    {
        // Load in environment variables from ".env"
        $this->setupPaths($root);

        $this->container = container();

        foreach ($services as $name => $service) {
            $this->container->bind($name, $service);
        }

        $this->container->get('logger')->pushHandler(new StreamHandler($this->paths['log_file'], Logger::WARNING));
        $this->container->get('stopwatch')->start('application');

        $this->container->get('config')->loadConfigurationFiles(
            $this->paths['config_path'],
            $this->getEnvironment()
        );

        $this->bindEventListeners();

        $this->container->get('templater')->addEngine(new PhpEngine(
            new TemplateNameParser(), 
            new FilesystemLoader($this->paths['view_path'])
        ));

        $database = $this->container->get('database');
        $database->addConnection($this->container->get('config')->get('database.default'));
        $database->setAsGlobal();
        $database->bootEloquent();
    }

    /**
     * Bind the application event listeners given the
     * event configuration.
     * 
     * @return void
     */
    private function bindEventListeners()
    {
        $dispatcher = $this->container->get('dispatcher');
        $config = $this->container->get('config')->get('events');

        $listeners = $config['listeners'];

        foreach ($listeners as $key => $listener) {
            $listener = new $listener;



            $this->listeners[] = $listener;
        }
    }

    /**
     * Initialize the paths.
     *
     * @param  string $root
     * @return void
     */
    private function setupPaths($root)
    {
        $this->paths['env_file_path'] = $root;
        $this->paths['env_file']      = $this->paths['env_file_path'].'.env';
        $this->paths['config_path']   = $root . '/config';
        $this->paths['log_file']      = $root . '/logs/scaffold.log';
        $this->paths['view_path']     = $root . '/views/%name%';
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

        $this->profile = $this->container->get('stopwatch')->stop('application');

        $this->profile = [
            'memory' => humanFileSize($this->profile->getMemory(), 'MB'),
            'time'   => $this->profile->getDuration() . 'ms',
        ];

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
}