<?php 

use Scaffold\Foundation\Container;

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
 * Die and pretty-dump some
 * data for debugging purposes.
 * 
 * @param  mixed $what
 * @return void
 */
function dd($what)
{
    dump($what);
    die();
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
