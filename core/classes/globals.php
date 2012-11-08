<?php !defined('IN_APP') and header('location: /');

class Globals {
	public static $globals = array();
	
	public static function set($key, $val) {
		self::$globals[$key] = $val;
	}
	
	public static function get($key, $fallback = '') {
		if(isset(self::$globals[$key])) {
			return self::$globals[$key];
		}
		
		return $fallback;
	}
}