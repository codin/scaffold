<?php 

// Include helper functions
include_once 'helpers.php';

// Create the new app instance with our
// service instances
$app = new Scaffold\Foundation\App(__DIR__ . '/../', [
    
    // Services required in order for Scaffold
    // to function correctly.
    'config'     => new Scaffold\Foundation\Config(),
    'request'    => new Scaffold\Http\Request(),
    'response'   => new Scaffold\Http\Response(),
    'router'     => new Scaffold\Http\Router(),
    'stopwatch'  => new Symfony\Component\Stopwatch\Stopwatch(),

    // Optional Services which can be 
    // disabled or altered.
    'database'   => new Illuminate\Database\Capsule\Manager(),
    'logger'     => new Monolog\Logger('scaffold'),
    'templater'  => new Symfony\Component\Templating\DelegatingEngine(),
    'dispatcher' => new Symfony\Component\EventDispatcher\EventDispatcher(),
    'cache'      => new Scaffold\Caching\Cache(
        new Scaffold\Caching\Adapters\FileCacheAdapter()
    ),
    
    // Your custom application services 
    // can go below here:
]);

// Include our routes file
include_once '../app/routes.php';

// Match our routes
$app->matchRoutes();

// Render our response
$app->render();