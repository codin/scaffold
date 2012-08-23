<?php !defined('IN_APP') && header('location: /');

class Routes {
    private $routes = array();
    private $url = false;
    
    public function __construct() {
        //  Set our routes up
        $this->routes = Config::get('routes');
        
        //  Store the current URL
        $this->url = substr(Url::request(), 1);
        
        //  Set a fallback
        if(!$this->url) {
            $this->url = Config::get('default_method');
        }
    }
    
    public function parse() {
        $search = array(':any', ':num', ':alpha');
        $replace = array('[0-9a-zA-Z~%\.:_\\-]+', '[0-9]+', '[a-zA-Z]+');
        
        $this->error = $this->routes['error'];
        unset($this->routes['error']);
        
        //  Loop through our routes
        foreach(array_reverse($this->routes) as $route => $controller) {
            $route = str_replace($search, $replace, $route);
            
            //  Match the route against the URL 
            preg_match('#^' . $route . '$#', $this->url, $matches);
            
            if(isset($matches[0])) {
                return $controller;
            }
        }
        
        return $this->error;
    }
}