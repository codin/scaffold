<?php !defined('IN_APP') and header('location: /');

class Email {
    public $to;
    
    public static function send($to, $subject, $content) {
     	if(Config::get('email.type') == 'postmark') {
     		Postmark::send($to, $subject, $content);
     	}   
    }
}

// POST MARK HERE

class Postmark {

	public static function send($to, $subject, $message) {
		
		$sender = Config::get('email.from');
		$key = Config::get('email.postmark.apiKey');
		
		//  Set headers to send to Postmark
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json',
			'X-Postmark-Server-Token: ' . $key
		);
		
		Request::post('http://api.postmarkapp.com/email',
			json_encode(array(
				'From' => $sender,
				'To' => $to,
				'Subject' => $subject,
				'HtmlBody' => $message
			)
		);
		
		Request::set(CURLOPT_HTTPHEADER, $headers);
		return Request::send()->status;
	}
}