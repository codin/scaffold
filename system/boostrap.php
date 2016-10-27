<?php 

/**
 * This file bootstraps the entire framework
 */

// Include helper functions
include_once 'helpers.php';

// Create the new app instance
$app = new \Scaffold\Foundation\App(__DIR__ . '/../');

// Include our routes file
include_once '../config/routes.php';

// Match our routes
$app->matchRoutes();

// Render our response
$app->render();