<?php !defined('IN_APP') and header('location: /');

class Email {
    public $to, $subject, $body;
    
    public function to($who) {
    	if(isset($who)) {
    		$this->to = $who;
    	}
    	
    	return $this;
    }
    
    public function subject($value) {
    	if(isset($value)) {
    		$this->subject = $value;
    	}
    	
    	return $this;
    }
    
    public function body($value) {
    	if(isset($value)) {
    		$this->body = $value;
    	}
    	
    	return $this;
    }
    
    public function send() {
     	if(!isset($this->to) or !isset($this->subject) or !isset($this->body)) {
     		return false;
     	}
     	
     	if(Config::get('email.type') == 'postmark') {
     		return Postmark::send((object) array(
     			'to' => $this->to,
     			'subject' => $this->subject,
     			'body' => $this->body
     		));
     	}
    }
}

// POST MARK HERE

class Postmark {

	public static function send($data) {
		// Get the config information
		$sender = Config::get('email.from');
		$pm = Config::get('email.postmark');
		$key = $pm['apiKey'];
				
		//  Set headers to send to Postmark
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json',
			'X-Postmark-Server-Token: ' . $key
		);
		
		dump(json_encode(array(
			'From' => $sender,
			'To' => $data->to,
			'Subject' => $data->subject,
			'HtmlBody' => $data->body
		)));
		
		Request::post('http://api.postmarkapp.com/email',
			json_encode(array(
				'From' => $sender,
				'To' => $data->to,
				'Subject' => $data->subject,
				'HtmlBody' => '<h1>' . $data->body . '<h1>'
			)
		));
		
		Request::set(CURLOPT_HTTPHEADER, $headers);
		$return = Request::send();

		return $return;
	}
}