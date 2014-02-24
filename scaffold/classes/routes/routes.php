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
	public static function init($routes) {
		var_dump($routes);
		
		$routes = \options($routes);
		
		var_dump($routes);
	}
}