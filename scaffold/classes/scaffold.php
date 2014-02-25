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
	/**
	 *   Store our settings here. You shouldn't use this object to
	 *   modify anything, but it won't break if you do.
	 */
	public $settings;
	
	/**
	 *   Store all the matched routes we find.
	 */
	public $routes;
	
	/**
	 *   A list of all function aliases. To use with __call().
	 */
	public $aliases = array(
		'get' => '\Scaffold\Routes\Routes::get',
		'post' => '\Scaffold\Routes\Routes::post',
		'put' => '\Scaffold\Routes\Routes::put',
		'delete' => '\Scaffold\Routes\Routes::delete',
		
		'view' => '\Scaffold\View'
	);
	
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
	
	/**
	 *   Automatically try to load any class here.
	 *   TODO: Probably a better way to do this.
	 */
	public function __call($name, $vars) {
		if(isset($this->aliases[$name])) {
			//  Handle non-static classes
			if(strpos($this->aliases[$name], ':') === false) {
				return new $this->aliases[$name]($vars);
			}
			
			//  And handle static classes here
			return call_user_func_array($this->aliases[$name], $vars);
		}
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