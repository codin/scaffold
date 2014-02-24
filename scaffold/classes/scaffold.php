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
 
namespace Scaffold;

class Scaffold {
	public $settings;
	public $routes;
	
	/**
	 *   Set up our settings object
	 *
	 *   @param	$settings	A string or array 
	 */
	public function __construct($settings = false) {
		if($settings !== false) {
			$this->settings = \options($settings);
		}
		
		//  Build the rest of Scaffold's application up
		//  return $this->init();
	}
	
	public function __call($name, $vars) {
		var_dump($name, $vars);
	}
	
	/**
	 *   Set up our routes object
	 *
	 *   @param	$routes		A string or array 
	 */
	public function routes($routes) {
		return $this->routes = \Scaffold\Routes\Routes::init($routes);
	}
	
	/**
	 *   Set up our routes object
	 *
	 *   @param	$routes		A string or array 
	 */
	public function run() {
		echo Helpers\Storage::get('what');
	}
}