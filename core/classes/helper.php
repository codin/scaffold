<?php !defined('IN_APP') and header('location: /');

class Helper {
	private static $base = APP_BASE;
	private static $url = 'helpers/?.php';
	
	public function __construct() {
		//  Load the core helpers
		foreach(glob(CORE_BASE . 'helpers/*.php') as $file) {
			require_once $file;
		}
	}
	
	//  Load a helper with an optional full URL
	public function load($helper, $url = false) {
		//  Handle arrays
		if(is_array($helper)) {
			foreach($helper as $h) {
				$this->load($h);
			}
			
			return;
		}
		
		
		if($url === false) {
			$url = self::$base . str_replace('?', preg_replace('/(\/.*)+/', '', $helper), self::$url);
			
			if(!file_exists($url)) {
				return false;
			}
		}
		
		//  Load the file
		fetch($url);
		
		//  Instantiate the helper
		$u = ucfirst($helper);
		if(class_exists($u) and !isset($this->{$helper})) {
			$this->{$helper} = new $u;
		}
		
		return $this;
	}
}