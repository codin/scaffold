<?php !defined('IN_APP') && header('location: /');

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
}