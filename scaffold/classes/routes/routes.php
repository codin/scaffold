<?php 

/**
 *   Scaffold, a tiny PHP webapp framework.
 *
 *   @author	Codin' Co. <hi@codin.co>
 *   @version	2.0.0-alpha
 *   @package	Scaffold
 *
 *   Here goes nothin’.
 */
 
namespace Scaffold\Routes;

class Routes {
	public static $routes = array();
	
	public static function init($routes = array()) {
		self::$routes = \options($routes);
	}
	
	public static function get($url, $callback) {
		if($url) $callback($url, 'hello');
	}
}