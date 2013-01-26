<?php

class Postmark extends Email {
	public function __construct() {
		$this->headers = array(
			'Accept: application/json',
			'Content-Type: application/json',
			'X-Postmark-Server-Token: ' . Config::get('email.postmark.apiKey')
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
		Request::post('http://api.postmarkapp.com/email', $this->parseData());
		
		Request::set(CURLOPT_HTTPHEADER, $this->headers);
		$return = Request::send();

		return isset($return->data) ? $return->data : $return;
	}
	
	public function parseData() {
		return json_encode(array(
			'From' => $this->from,
			'To' => $this->to,
			'Subject' => $this->subject,
			'HtmlBody' => $this->message
		));
	}
}

