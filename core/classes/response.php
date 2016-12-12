<?php !defined('IN_APP') and header('location: /');

class Response {
	public static function redirect($url) {
		if(!self::sent()) {
			header(self::_getStatuses(301));
			header('location: ' . $url);
		} else {
			//  Too late. Might as well try to redirect, anyway
			echo '<script>window.location = ' . $url . '</script>';
			echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
		}
		
		exit;
	}
	
	public static function set($status = 200) {
		if(!self::sent()) {
			return header(self::_getStatuses($status));
		}
		
		return false;
	}
	
	public static function sent() {
		return headers_sent();
	}
	
	private static function _getStatuses($code = 0) {
		$codes = array(
			200 => 'HTTP/1.0 200 OK',
			301 => 'HTTP/1.1 301 Moved Permanently',
			404 => 'HTTP/1.0 404 Not Found',
			
			//  Javascript headers
			'js' => 'content-type: application/javascript',
			'json' => 'content-type: application/json',
			
			//  CSS headers
			'css' => 'content-type: text/css',
			
			//  XML/RSS headers
			'xml' => 'content-type: text/xml',
			'rss' => 'content-type: text/xml',
			
			//  Images
			'png' => 'content-type: image/png',
			'jpg' => 'content-type: image/jpg; content-type: image/jpeg',
			'gif' => 'content-type: image/gif'
		);
		
		if(isset($codes[$code])) {
			return $codes[$code];
		}
		
		return false;
	}
}