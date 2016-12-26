<?php 

/**
 * Define application routing here
 */

// Pull in the router
$router = container('router');

// Define our home route
$router->route('GET', '/', [
    'name'       => 'home',
    'controller' => '\App\Controllers\PagesController@home',
]);

// define a route with a parameter
$router->route('GET', '/test/{slug}', [
    'name'       => 'test',
    'controller' => '\App\Controllers\PagesController@test',
]);

$router->resource('articles', ['read']);