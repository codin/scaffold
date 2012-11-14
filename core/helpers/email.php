<?php !defined('IN_APP') and header('location: /');

class Email {
	public $to, $subject, $body;
	
	public function to($who) {
		return $this->set('to', $who);
	}
	
	public function subject($value) {
		return $this->set('subject', $value);
	}
	
	public function body($value) {
		return $this->set('body', $value);
	}
	
	public function set($key, $val) {
		if($key and $val) $this->{$key} = $val;
		return $this;
	}
	
	public function send() {
	 	if(!isset($this->to) or !isset($this->subject) or !isset($this->body)) {
	 		return false;
	 	}
	 	
	 	if(Config::get('email.type') == 'postmark') {
	 		return Postmark::send(array(
	 			'From' => Config::get('email.from'),
	 			'To' => $this->to,
	 			'Subject' => $this->subject,
	 			'HtmlBody' => $this->body
	 		));
	 	}
	}
}

// POST MARK HERE

class Postmark {

	public static function send($data) {

		// Get the config information
		$pm = Config::get('email.postmark');
		$key = $pm['apiKey'];
				
		//  Set headers to send to Postmark
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json',
			'X-Postmark-Server-Token: ' . $key
		);
		
		Request::post('http://api.postmarkapp.com/email', json_encode($data));
		
		Request::set(CURLOPT_HTTPHEADER, $headers);
		$return = Request::send();

		return $return;
	}
}