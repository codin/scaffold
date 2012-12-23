<?php !defined('IN_APP') and header('location: /');

class Input {

	public static function posted($what = false) {
	
		if($what !== false) {
			if(is_array($what)) {
				foreach($what as $field) {
					if(!isset($_POST[$field]) or empty($_POST[$field])) return false;
				}
				
				return true;
			}
			
			return isset($_POST[$what]);
		}
	
		return count($_POST) > 0;
	}

	public static function get($var = false, $fallback = '') {
		if($var === false) {
			foreach($_GET as $key => $value) {
				self::get($key);
			}
		}
		
		return self::_receive($_GET, $var, $fallback);
	}

	public static function post($var, $fallback = '') {
		if($var === false) {
			foreach($_POST as $key => $value) {
				self::post($key);
			}
		}
		
		return self::_receive($_POST, $var, $fallback);
	}
	
	public static function server($var, $fallback = '') {
		return self::_receive($_SERVER, strtoupper($var), $fallback);
	}
	
	public static function escape($str) {
		return filter_var($str, FILTER_SANITIZE_STRING);
	}
	
	//  Input::hash('password', 'post');
	public static function hash($data, $method = 'post') {
		if(method_exists(__CLASS__, $method)) {
			return Crypt::encrypt(self::$method($data));
		}
	}
	
	private static function _receive($type, $var, $fallback = '') {
		if(isset($type[$var])) {
			return self::escape($type[$var]);
		}
		
		return $fallback;
	}
}