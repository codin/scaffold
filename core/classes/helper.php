<?php !defined('IN_APP') && header('location: /');


/**
 *	The helper main class loads all of our helpers.
 *  Using this class we can target the helpers.
 */
 
class Helper {
	
	public function __construct() {
		
	}
	
	private function get() {
		$contents = scandir(APP_BASE . 'lib/helpers/');
	}
}