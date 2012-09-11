<?php !defined('IN_APP') and header('location: /');

class Request {
	
	private static $_curl;
	
	public static function init() {
		self::$_curl = curl_init();
	}
	
	public static function post($url, $vars = array()) {
		$vars = (array) $vars;
		
		// URL fitting
		$vars_string = http_build_query($vars);
		
		// Set our options
		self::set(CURLOPT_POST, count($vars));
		self::set(CURLOPT_POSTFIELDS, $vars_string);
		
		self::doRequest($url);
	}
	
	private static function doRequest($url) {
	    if(!self::$_curl) {
	        self::init();
	    }
		
		self::set(CURLOPT_RETURNTRANSFER, true);
		self::set(CURLOPT_URL, $url);
	}
	
	public static function get($url) {
		// URL fitting
		self::doRequest($url);
	}
	
	public static function send() {
		// get the data and close the connection
		$data = curl_exec(self::$_curl);
		$status = curl_getinfo(self::$curl, CURLINFO_HTTP_CODE);
		curl_close(self::$_curl);
		
		return (object) array('data' => $data, 'status' => $status);
	}
	
	public static function set($opt, $value) {
		return curl_setopt(self::$_curl, $opt, $value);
	}

}