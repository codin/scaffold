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

$router->route('GET', '/this-is-a-test/{param}', [
    'name'       => 'test',
    'controller' => '\App\Controllers\PagesController@home',
]);