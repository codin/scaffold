<?php !defined('IN_APP') && header('location: /');

class Routes {
    private $routes = array();
    private $url = false;
    
    public function __construct() {
        //  Set our routes up
        $this->routes = Config::get('routes');
        
        //  Store the current URL
        $this->url = Url::segment(0, false);
    }
    
    public function parse() {
        $search = array(':any', ':num', ':alpha');
        $replace = array('[0-9a-zA-Z~%\.:_\\-]+', '[0-9]+', '[a-zA-Z]+');
        
        $error = $this->routes['error'];
        unset($this->routes['error']);
        
        //  Loop through our routes
        foreach($this->routes as $route => $controller) {
            $route = str_replace($search, $replace, $route);
            
            preg_match('#^' . $route . '#', $this->url, $matches);
            
            if($matches[0]) {
                return $controller;
            }
        }
        
        return $error;
    }
}