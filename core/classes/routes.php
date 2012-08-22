<?php !defined('IN_APP') && header('location: /');

class Routes {
    private $routes = array();
    private $url = false;
    
    public function __construct() {
        //  Set our routes up
        $this->routes = Config::get('routes');
        
        //  And parse/output
        $this->parse();
        
        //  Store the current URL
        $this->url = Url::segment(0, false);
    }
    
    public function parse() {
        //  Loop through our routes
        foreach($this->routes as $route => $controller) {
            //    preg_replace(', $replacement, $subject[, $limit=-1[, &$count]])
//            echo $route . ' ' . $controller;
        }
    }
}