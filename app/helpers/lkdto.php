<?php defined('IN_APP') or die('Get out of here');

class Lkdto {
	public $user;
	private $_endpoint = 'http://lkd.to/api/';
	private $_data = array();
	
	public static function get($what, $user = '') {
		echo 'it worked, again!';
	}
	
	public static function setUser($user) {
		self::$user = $user;
	}
	
	public static function getUser() {
		return self::$user;
	}
	
	private static function _fetch($method, $append = '') {
		if(!isset(self::$_data[$method])) {
			self::$_data[$method] = Request::get(self::$_endpoint . $method . $append);
		}
		
		return self::$_data[$method];
	}
}