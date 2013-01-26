<?php !defined('IN_APP') and header('location: /');

class Config {
	private $config;
	private static $instance;
	
	public function __construct($data) {
		$this->config = $data;
		
		//  Set up the defaults for environment
		$this->_setDefaults('env', 'mode', array(
			'live' => array(
				'error_reporting' => -1,
				'log' => false,
				'debug' => false
			),
			'local' => array(
				'error_reporting' => E_ALL & ~E_NOTICE,
				'log' => true,
				'debug' => true
			)
		));
	}
	
	public static function get($what, $fallback = '') {
		return self::instance()->_get($what, $fallback);
	}
	
	public static function set($what, $value) {
		return self::instance()->_set($what, $value);
	}
	
	public static function all() {
		return self::instance()->_all();
	}
	
	
	//  Private methods
	//  Just to make getting config a little easier
	
	//  Create a static instance
	public static function instance() {
		global $config;
		
		if(!isset(self::$instance)) {
			self::$instance = new self($config);
		}
		
		return self::$instance;
	}

	//  Grab an item from the config
	private function _get($what, $fallback) {
	
		//  Handle sub-config calls
		if(strpos($what, '.') !== false) {
			$config = explode('.', $what);
			$str = $this->config;

			foreach($config as $key) {
				if(isset($str[$key])) {
					$str = $str[$key];
				}
			}
			
			return $str === $this->config ? $fallback : $str;
		}
	
		if(isset($this->config[$what])) {
			return $this->config[$what];
		}
		
		return $fallback;
	}
	
	private function _setDefaults($key, $check, $val) {
		$config = isset($this->config[$key]) ? $this->config[$key] : array();
		
		if(!isset($config[$check])) {
			// return Error::log('Could not set default: ' . $key . '.' . $check);
			return false;
		}
		
		//  Loop through the config keys and add
		$replace = $val[$config[$check]];
		foreach($replace as $k => $v) {
			//  Don't overwrite
			if(!isset($this->config[$key][$k])) {
				$this->config[$key][$k] = $v;
			}
		}
		
		return $this->config;
	}
	
	private function _set($what, $value) {
		return $this->config[$what] = $value;
	}
	
	private function _all() {
		return $this->config;
	}
}