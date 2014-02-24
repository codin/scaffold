<?php 

/**
 *   Scaffold, a tiny PHP webapp framework.
 *
 *   @author	Codin' Co. <hi@codin.co>
 *   @version	2.0.0-alpha
 *   @package	Scaffold
 *
 *   This is just a sample usage for Scaffold. Adjust for taste.
 */
 
 
/**
 *   Load our main Scaffold file. We'll load more in later.
 */
require 'scaffold/init.php';

/**
 *   Set up our Scaffold object as $app.
 *   We can give Scaffold options three ways:
 *    1. Passing an array of options as parameters.
 *	  2. Passing the name of a file as a string parameter.
 *	  3. Passing the name of a directory as a string parameter.
 */
$app = new \Scaffold\Scaffold('app/config');

/**
 *   We'll include a directory of routes instead of muddying up
 *   our main file, so we can call the routes() method to auto-
 *   load an entire folder of routes.
 */
$app->routes('app/routes');

/**
 *   And start the application!
 */
$app->run();