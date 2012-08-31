<?php !defined('IN_APP') and header('location: /');

class Request {
	
	private static $_curl;
	
	public static function post($url, $vars = array()) {
		
		// cast it to an array
		$vars = (array) $vars;
		
		// Init our curl
		self::$_curl = curl_init();
		
		// URL fitting
		$vars_string = http_build_query($vars);

		// Set our options
		self::_set(CURLOPT_URL, $url);
		self::_set(CURLOPT_POST, count($vars));
		self::_set(CURLOPT_POSTFIELDS, $vars_string);
		
		// get the data and close the connection
		$data = curl_exec(self::$_curl);
		curl_close(self::$_curl);
		
		return $data;
	}
	
	private function _set($opt, $value) {
		return curl_setopt(self::$_curl, $opt, $value);
	}

}