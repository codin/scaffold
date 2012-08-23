<?php !defined('IN_APP') && header('location: /');

<<<<<<< HEAD

/**
 *	The helper main class loads all of our helpers.
 *  Using this class we can target the helpers.
 */
 
class Helper {
	
	public function __construct() {
		
	}
	
	private function get() {
		$contents = scandir(APP_BASE . 'lib/helpers/');
	}
=======
class Helper {
    
    //  Load a helper with an optional full URL
    public function load($helper, $url = false) {
        if($url === false) {
            $url = APP_BASE . 'helpers/' . preg_replace('/(\/.*)+/', '', $helper) . '.php';
        }
        
        //  Handle arrays
        if(is_array($helper)) {
            foreach($helper as $h) {
                $this->load($h);
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
>>>>>>> 3b91b2596bca292502513908439df908e8246257
}