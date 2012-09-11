<?php !defined('IN_APP') and header('location: /');

class Helper {
    
    //  Load a helper with an optional full URL
    public function load($helper, $url = false) {
        if($url === false) {
            $url = 'helpers/' . preg_replace('/(\/.*)+/', '', $helper) . '.php';
            
            if(file_exists(APP_BASE . $url)) {
            	$url = APP_BASE . $url;
            } else {
            	$url = CORE_BASE . $url;
            }
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
}