<?php !defined('IN_APP') && header('location: /');

class Input {

	public static function posted($what = false) {
	
	    if(!empty($what)) {
            if(is_array($what)) {
                foreach($what as $field) {
                    if(!isset($_POST[$field]) and !empty($_POST[$field])) return false;
                }
                
                return true;
            }
            
            return isset($_POST[$what]);
    	}
	
		return count($_POST) > 0;
	}

	public static function get($var, $fallback = '') {
		return self::_receive($_GET, $var, $fallback);
	}

	public static function post($var, $fallback = '') {
		return self::_receive($_POST, $var, $fallback);
	}
	
	//  Input::hash('password', 'post');
	public static function hash($data, $method = 'post') {
		if(method_exists(__CLASS__, $method)) {
			return sha1(self::$method($data));
		}
	}
	
	private static function _receive($type, $var, $fallback = '') {
		if(isset($type[$var])) {
			return Database::escape($type[$var]);
		}
		
		return $fallback;
	}
}