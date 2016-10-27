<?php 

/**
 * Define application routing here
 */

// Pull in the router
$router = $app->get('router');


// Define our home route
$router->addRoute('GET', '/', [
    'name' => 'home',
    'controller' => 'App:Controllers:PagesController:home',
]);