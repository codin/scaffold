<?php 

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