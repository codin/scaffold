<?php defined('IN_APP') or die('Get out of here');

class Controller {
    public function __construct() {
        global $scaffold;
        
        foreach($scaffold->classes() as $name => $class) {
            $this->{$name} = $class;
        }
        
        if(get_called_class() === __CLASS__) {
            $this->_loadController();
        }
    }
    
    private function _loadController() {
        $controller = $this->routes->parse();
        
        $u = ucfirst($controller) . '_controller';
        
        $path = APP_BASE . 'controllers/' . $controller . '.php';
        
        if(file_exists($path)) {
            include_once $path;
            
            if(class_exists($u)) {
                $controller = new $u;
                
                //  Call the methods
                $method = Config::get('default_method', false);
                if($method && method_exists($controller, $method)) {
                    $controller->{$method}();
                }
            }
        }
        
        return $controller;
    }
}