<?php !defined('IN_APP') and header('location: /');

class Scaffold {

    public static $data;
    protected $config;
    public static $instance;
    
    public function __construct($data = array()) {
        if(!empty($data)) {
            $this->_assemble($data);
            
            //  Get the right files, and call
            $this->_build($this->data->routes->parse());
        }
    }
        
    //  Assemble all of the core classes
    private function _assemble($data) {
        global $config;
        
        //  Loop our classes
        foreach($data as $class) {
            //  And instantiate
            $u = ucfirst($class);
            
            //  But only if the class doesn't exist
            if(class_exists($u)) {
                $this->data->{$class} = new $u($config);
            } else {
                Error::log('Class ' . $u . ' does not exist');
            }
        }
    }
    
    public static function instance() {
        self::$instance =& $this;
        
        return self::$instance;
    }
    
    public static function data() {
        return self::$data;
    }
    
    //  And build our controllers, models, and views
    private function _build($class) {
        $class = array($class);
        
        //  If we're calling a function directly
        if(strpos($class[0], '.') !== false) {
            $class = explode('.', $class[0]);
            $class = array($class[0], $class[1]);
        } else {
            $class[1] = Config::get('default_method');
        }
        
        //  $class[0] is the controller/model/view
        //  First character capitalised
        $u = ucfirst($class[0]);
                
        //  Load the controller
        foreach(array('model', 'controller') as $type) {
            
            //  Load our routed classes
            $file = APP_BASE . $type . 's/' . $class[0] . '.php';
            
            //  Check the file exists, first
            if(file_exists($file)) {
                include_once $file;
                
                //  Might as well call the right class name now, then
                //  It's a double "u"
                $w = $u . '_' . $type;
                if(class_exists($w)) {
                    //  Load the default ones, which always exist (they're in this file)
                    $baseClass = ucfirst($type);
                    $this->{'default' . $type} = new $baseClass($this->data);
                    
                    //  Set the class
                    $this->data->{$type . 's'}->{$class[0]} = new $w($this->data);
                    
                    //  Store our new class in a variable, since it's hard to read
                    $newClass = $this->data->{$type . 's'}->{$class[0]};
                    
                    //  Check we have something to call
                    if(isset($class[1]) and method_exists($newClass, $class[1])) {
                        //  Call the class
                        //  Ignore the double colons, it's not just static classes
                        call_user_func(get_class($newClass) . '::' . $class[1]);
                    }
                }
            } else {
                Error::log('Class ' . $u .  '_' . $type . ' not found. Tried looking for ' . $file . ', but it was not there.');
            }
        }
    }
}

//  Our default controller
class Controller extends Scaffold {
    public function __construct($data) {
        foreach($data as $k => $v) {
            $this->{$k} = $v;
        }
    }
}

class Model extends Scaffold {
    public function __construct($data) {
        foreach($data as $k => $v) {
            $this->{$k} = $v;
        }
    }
}