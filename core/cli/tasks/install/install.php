<?php !defined('IN_APP') and header('location: /');

class Install extends Command {
	public static $endpoint = 'http://localhost:8000/';
	
	//  Let's go.
	public function __construct() {
		parent::__construct();
	}
	
	//  And handle the argument
	public function run($arg) {
		if(!$arg) {
			return $this->error('Wait, what did you want me to install?');
		}
		
		$json = $this->_getJSON($arg);
		
		return 'Helper "' . $arg . '" installed successfully.';
	} 
	
	private function _getJSON($slug) {
		return json_decode(Request::get(self::$endpoint . $slug . '/about.json'));
	}
}