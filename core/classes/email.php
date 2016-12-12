<?php !defined('IN_APP') and header('location: /');

class Email {
	private $_method, $_class;
	
	public  $from, $to, $replyTo,
			$subject, $message;
	
	public function __construct() {
		//  Set up the defaults
		$this->_method = Config::get('email.type', 'standard');

		//  Initialise the right class
		$this->_init();
	}
	
	public function __call($method, $args) {
		//  If there's a method, call it
		if(method_exists($this->_class, $method)) {
			$call = call_user_func_array(array($this->_class, $method), $args);
			
			//  Don't chain if it returns something
			if(!is_null($call)) {
				return $call;
			}
		} else {
			//  Otherwise, just set it manually
			$this->_class->set($method, first($args));
		}
		
		return $this;
	}
	
	private function _init() {
		$path = CORE_BASE . 'classes/email/' . $this->_method . '.php';
		
		//  If it doesn't exist, fall back to standard email
		if(!file_exists($path)) {
			$this->_method = 'standard';
			return $this->_init();
		}
		
		//  Grab the file
		grab($path);
		
		$class = ucfirst($this->_method);
		$this->_class = new $class;
	}
}