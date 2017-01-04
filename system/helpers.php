<?php 

use Scaffold\Eventing\Event;
use Scaffold\Foundation\Container;

/**
 * Pull data from the environment
 * 
 * @param  string  $name
 * @param  boolean|mixed $fallback
 * @return mixed
 */
function env($name, $fallback = false)
{
    if ($data = getenv($name)) {
        return $data;
    }

    return $fallback;
}

/**
 * Pretty-dump some
 * data for debugging purposes.
 * 
 * @param  mixed $what
 * @return void
 */
function dump($what)
{
    echo '<pre>';
    var_dump($what);
    echo '</pre>';
}

/**
 * Human file size
 * 
 * @param  int $size
 * @param  string $unit
 * @return string
 */
function human_file_size($size, $unit = false)
{
    if ((!$unit && $size >= 1<<30) || $unit == "GB") {
        return number_format($size/(1<<30), 2)."GB";
    }
    
    if ((!$unit && $size >= 1<<20) || $unit == "MB") {
        return number_format($size/(1<<20), 2)."MB";
    }

    if ((!$unit && $size >= 1<<10) || $unit == "KB") {
        return number_format($size/(1<<10), 2)."KB";
    }

    return number_format($size)." bytes";
}
    
/**
 * Fetch the container or retrieve stuff from it?
 * 
 * @param  string|null $make
 * @return Scaffold\Foundation\Container
 */
function container($make = null)
{
    if (is_null($make)) {
        return Container::getInstance();
    }

    return Container::getInstance()->get($make);
}

/**
 * Get the app instance
 * 
 * @return Scaffold\Foundation\App
 */
function app()
{
    return container('app');
}

/**
 * Get the instance of our config loader
 *
 * @return Scaffold\Foundation\Config
 */
function config()
{
    return container('config');
}

/**
 * Get the session instance
 * 
 * @return Scaffold\Session\Session
 */
function session()
{
    return container('session');
}

/**
 * Get the response instance
 * 
 * @return Scaffold\Http\Response
 */
function response()
{
    return container('response');
}

/**
 * Get the request instance
 * 
 * @return Scaffold\Http\Request
 */
function request()
{
    return container('request');
}

/**
 * Dispatch a new event
 * 
 * @param  Event  $event
 * @return Event  $event
 * @throws EventNotDispatchedException
 */
function dispatch(Event $event)
{
    $events = config()->get('events.events');
    $classname = get_class($event);
    $name = $event->getEventName();

    if (isset($events[$classname])) {
        $name = $events[$classname];
    }

    return container('dispatcher')->dispatch($name, $event);
}

/**
 * Fetch our storage system from the
 * container so we can interact with files.
 * 
 * @return Scaffold\Storage\Storage
 */
function storage()
{
    return container('storage');
}

/**
 * Get the app paths with an option to
 * pass in a specific key.
 * 
 * @param  boolean $key
 * @return string|array
 */
function paths($key = false)
{
    $paths = app()->getPaths();

    if ($key && isset($paths[$key])) {
        return rtrim($paths[$key], '/');
    }

    return $paths;
}
    
/**
 * Get the public path
 * 
 * @return string
 */
function public_path()
{
    return paths('public_path');
}

/**
 * Get the asset path
 * 
 * @return string
 */
function asset_path()
{
    return paths('asset_path');
}

/**
 * Get the view path
 * 
 * @return string
 */
function view_path()
{
    return paths('view_path');
}

/**
 * Get the module path
 * 
 * @return string
 */
function module_path()
{
    return paths('module_path');
}
    
/**
 * Render a module by it's name, this is a lowercase
 * identifier for the module.
 * 
 * @param  string $name
 * @param  array  $arguments
 * @return void
 */
function module($name, $arguments = [])
{
    $config = config()->get('templating');

    if (!isset($config['modules'][$name])) {
        throw new Exception('Module mapping not found');
    }

    $class = $config['modules'][$name];

    new $class($arguments);
}

/**
 * Gain access to the csrf manage
 * 
 * @return Symfony\Component\Security\Csrf\CsrfTokenManager
 */
function csrf()
{
    return container('csrf');
}

/**
 * Gain access to the cookie handler
 * for the applications response.
 * 
 * @return Scaffold\Http\Cookie
 */
function cookie()
{
    return container('cookie');
}

/**
 * Gain access to the caching system stored
 * in the container service.
 * 
 * @return Scaffold\Storage\Caching\Cache
 */
function cache()
{
    return container('cache');
}

/**
 * Get the cache path
 * 
 * @return string
 */
function cache_path()
{
    return paths('cache_path');
}
    
/**
 * The main directory for storage of files in 
 * the local file system.
 * 
 * @return string
 */
function storage_path()
{
    return paths('storage_path');
}