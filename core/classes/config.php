<?php !defined('IN_APP') && header('location: /');

class Config {
	private $config;
	private static $instance;
	
	public function __construct($data) {
	    $this->config = $data;
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
	    if(isset($this->config[$what])) {
	        return $this->config[$what];
	    }
	    
	    return $fallback;
	}
	
	private function _set($what, $value) {
	    return $this->config[$what] = $value;
	}
	
	private function _all() {
	    return $this->config;
	}
}