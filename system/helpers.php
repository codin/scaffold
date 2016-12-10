<?php 

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
function humanFileSize($size, $unit = false)
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

    if (!isset($events[$classname])) {
        throw new EventNotDispatchedException('Cannot find event name matching classname of event which was dispatched.');
    }

    $name = $events[$classname];

    return container('dispatcher')->dispatch($name, $event);
}
