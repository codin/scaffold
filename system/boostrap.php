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

    // Optional Services which can be 
    // disabled or altered.
    'cache'      => new Scaffold\Caching\Cache(new Scaffold\Caching\Adapters\FileCacheAdapter()),
    'database'   => new Illuminate\Database\Capsule\Manager(),
    'dispatcher' => new Symfony\Component\EventDispatcher\EventDispatcher(),
    'logger'     => new Monolog\Logger('scaffold'),
    'stopwatch'  => new Symfony\Component\Stopwatch\Stopwatch(),
    'templater'  => new Symfony\Component\Templating\DelegatingEngine(),
    
    // Your custom application services 
    // can go below here:
]);

// Include our routes file
include_once '../app/routes.php';

// Match our routes
$app->matchRoutes();

// Render our response
$app->render();