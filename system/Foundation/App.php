<?php 

namespace Scaffold\Foundation;

use Dotenv\Dotenv;
use Scaffold\Foundation\Resolver;
use Scaffold\Http\Request;
use Scaffold\Http\Response;
use Scaffold\Http\Router;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Stopwatch\Stopwatch;
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
     * Do stuff when we boot the app up.
     */
    public function __construct($root)
    {
        // Load in environment variables from ".env"
        $dotenv = new Dotenv($root);
        $dotenv->load();

        $this->container = container();

        $this->container->bind('stopwatch', new Stopwatch());
        $this->container->get('stopwatch')->start('application');

        $this->container->bind('request', new Request());
        $this->container->bind('response', new Response());

        $this->container->bind('router', new Router());

        $this->container->bind('templater', new PhpEngine(new TemplateNameParser(), new FilesystemLoader($root . '/views/%name%')));
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

        $content .= '<!-- Profile ' . json_encode($this->profile) . ' -->';
        $response->setContent($content)->send();
    }
}