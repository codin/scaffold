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
    'session'    => new Scaffold\Session\Session(
        // By default we'll just use PHP sessions.
        new Scaffold\Session\Adapters\StandardSessionAdapter()
    ),

    // Optional Services which can be 
    // disabled or altered.
    'cache'      => new Scaffold\Caching\Cache(
        // By default use file based caching
        new Scaffold\Caching\Adapters\FileCacheAdapter()
    ),
    'cookie'     => new Scaffold\Http\Cookie(),
    'csrf'       => new Symfony\Component\Security\Csrf\CsrfTokenManager(
        // Make use of our custom manager with this CSRF component.
        null, new Scaffold\Session\Security\CsrfTokenManagerAdapter()
    ),
    'database'   => new Illuminate\Database\Capsule\Manager(),
    'dispatcher' => new Symfony\Component\EventDispatcher\EventDispatcher(),
    'mailer'     => new Scaffold\Mail\Mailer(
        // Use the Nette mailer by default
        new Nette\Mail\SendmailMailer()
    ),
    'logger'     => new Monolog\Logger('scaffold'),
    'queue'      => new Scaffold\Queue\Queue(
        new Scaffold\Queue\Adapters\DatabaseQueueAdapter()
    ),
    'stopwatch'  => new Symfony\Component\Stopwatch\Stopwatch(),
    'storage'    => new Scaffold\Storage\Storage(
        // By default we're just going to store things
        // locally in the filesystem.
        new Scaffold\Storage\Adapters\LocalStorageAdapter()
    ),
    'templater'  => new Symfony\Component\Templating\DelegatingEngine(),
    
    // Your custom application services 
    // can go below here:
]);

// Start our session.
session()->start();

// Setup some auth, remove this line if you don't
// wish to use any authentication within your app.
container()->bind('auth', new Scaffold\Auth\Auth(
    new Scaffold\Auth\Adapters\SessionAuthAdapter()
));

// Include our routes file
include_once '../app/routes.php';

// Match our routes
$app->matchRoutes();

// Render our response
$app->render();