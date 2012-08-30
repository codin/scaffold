<?php !defined('IN_APP') and header('location: /');

class Scaffold {

    public $data;
    public $config;
    private $classes;
    
    public function __construct($config, $classes) {
        //  Set the config
        $this->config = $config;
        
        //  Core classes
        $this->classes = $classes;
        
        //  Load our classes
        $this->_loadClasses();
    }
    
    private function _loadClasses() {
        foreach($this->classes as $class) {
            $path = CORE_BASE . 'classes/' . preg_replace('/(\/.*)/', '', $class) . '.php';
            
            if(file_exists($path)) {
                include_once $path;
                
                $u = ucfirst($class);
                if(class_exists($u)) {                
                
	                //  Handle static instances
	                //  We label them by using the method "init"
	                if(method_exists($u, 'init')) {
	                    $this->data->{$class} = call_user_func_array($u . '::init', array($this));
	                }
	                
                    $this->data->{$class} = new $u($this->config);
                    $this->objects[strtolower($u)] = $this->data->{$class};
                }
            }
        }
    }
    
    public function classes() {
        return $this->data;
    }
}