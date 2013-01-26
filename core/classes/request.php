<?php !defined('IN_APP') and header('location: /');

class Request {
	
	private static $_curl, $url;
	
	public static function init() {
		self::$_curl = curl_init();
	}
	
	public static function post($url, $vars = array()) {
		$count = min(1, count($vars));
		
		if(is_array($vars)) {
			$vars = http_build_query($vars);
		}
		
		// Set our options
		self::set(CURLOPT_POST, $count);
		self::set(CURLOPT_POSTFIELDS, $vars);
		
		return self::doRequest($url);
	}
	
	private static function doRequest($url) {
		self::$url = $url;

		if(!self::$_curl) {
			self::init();
		}

		self::set(CURLOPT_RETURNTRANSFER, true);
		self::set(CURLOPT_URL, self::$url);
		
		return self::send();
	}
	
	public static function get($url) {
		// URL fitting 
		return self::doRequest($url);
	}
	
	public static function getJSON($url) {
		$request = self::doRequest($url);
		$request->data = json_decode($request->data);
		
		return $request;
	}
	
	public static function send() {
		// get the data and close the connection
		$start = microtime(true);
		$data = curl_exec(self::$_curl);
		$status = curl_getinfo(self::$_curl, CURLINFO_HTTP_CODE);
		$finish = microtime(true);
		
		return (object) array('data' => $data, 'status' => $status, 'url' => self::$url, 'ex_time' => $finish - $start);
	}
	
	public static function set($opt, $value) {
		return curl_setopt(self::$_curl, $opt, $value);
	}

}