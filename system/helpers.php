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