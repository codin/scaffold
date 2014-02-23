<?php

namespace Scaffold;

/**
 *   The class handles the main section of the dirty work, it initialises the app,
 *	 and handles file configurations.
 *
 *   @author	Codin' Co. <hi@codin.co>
 *   @version	2.0.0-alpha
 *   @package	Scaffold
 *
 */

public class Scaffold {

	const OPTIONS_PATH = 'app/config/default';			/* The location of the default options */
	const ROUTES_PATH = 'app/routes';					/* The default path to the routes */

	public $options = array();

	/**
	 *	 Set up the Scaffold application
	 *	 @param $options - A path to options, an array of options or the directory of the options
	 *	 
	 */
	public function __construct($options = false) {

	}

	/**
	 *	 Set up a routing dir so we can autload classes
	 *	 @param $routes - Where the routes all are, if not specified, uses default value
	 */
	public function routes($routes = false) {
		if(!$routes) {
			$routes = self::ROUTES_PATH;
		}

		/**
		 *	 Autoload classes in routes dir
		 */
		spl_autoload_register(function($class) {
		    include  $routes . $class . '.php';
		});
	}

	public function get($route, $callback = false) {
		
		// TODO Check URL, instantiate respective route class, bind the callback to that class

		if()


		/**
		 *	 If a callback is supplied, bind it to route
		 */
		if(is_callable($callback)) {
			Closure::bind($callback, $controller, 'A');
		}
	}

	public function run() {

	}

}