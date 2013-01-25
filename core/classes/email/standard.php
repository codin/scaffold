<?php

class Standard extends Email {
	public function __construct() {
		$this->wrap = false;
		$this->headers = array(
			'X-Mailer' => 'Scaffold ' . SCAFFOLD_VERSION,
		);
		$this->from = Config::get('email.from');
	}
	
	public function set($key, $val) {
		$this->{$key} = $val;
	}
	
	public function message($msg) {
		$this->_originalMessage = $this->message = $msg;
	}
	
	public function wrap($num) {
		if($num === false) {
			$this->message = $this->_originalMessage;
			return;
		}
		
		$this->message = wordwrap($this->message, $num);
	}
	
	public function send() {
		return mail($this->to, $this->subject, $this->message, $this->_headers());
	}
	
	private function _headers() {
		//  PHP mail() doesn't accept from and replyTo as parameters, so we need
		//  to add them here
		$this->headers['From'] = $this->from;
		$this->headers['Reply-To'] = merge($this->replyTo, $this->from);
		
		//  Everything needs to be converted to a newlined string
		$return = '';
		
		foreach($this->headers as $header => $value) {
			if($value) {
				$return .= $header . ': ' . $value . PHP_EOL;
			}
		}
		
		//  Since we can't do a backwards search, we'll make the string go backwards
		$return = strrev($return);
		$return = preg_replace('/' . PHP_EOL . '/', '', $return, 1);
		
		return strrev($return);
	}
}