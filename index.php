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
 *   Instead of loading all of our routes here, we can autoload
 *   them in using glob(). It's more maintainable, but less
 *   secure.
 *
 *   If you know you're not going to be adding/removing routes,
 *   then replace the 
 */
foreach(glob('app/routes/*.php') as $file) {
	include $file;
}

/**
 *   And start the application!
 */
$app->run();