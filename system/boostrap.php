<?php 

// Include helper functions
include_once 'helpers.php';

// Create the new app instance with our
// service instances
$app = new Scaffold\Foundation\App(__DIR__ . '/../', [
    'config'    => new Scaffold\Foundation\Config(),
    'database'  => new Illuminate\Database\Capsule\Manager(),
    'finder'    => new Symfony\Component\Finder\Finder(),
    'logger'    => new Monolog\Logger('scaffold'),
    'request'   => new Scaffold\Http\Request(),
    'response'  => new Scaffold\Http\Response(),
    'router'    => new Scaffold\Http\Router(),
    'stopwatch' => new Symfony\Component\Stopwatch\Stopwatch(),
    'templater' => new Symfony\Component\Templating\DelegatingEngine(),
]);

// Include our routes file
include_once '../config/routes.php';

// Match our routes
$app->matchRoutes();

// Render our response
$app->render();