<?php defined('IN_APP') or die('Get out of here');

class Model {
    public function __construct() {
        global $scaffold;
        $classes = $scaffold->classes();
        
        //  Sanity check
        if(isset($classes['database'])) {
            return;
        }
        
        $this->db = $classes['database'];
        
        if(get_called_class() === __CLASS__) {
            $this->_loadModel();
        }
    }
    
    private function _loadModel() {
        $model = $this->routes->parse();
        $u = ucfirst($model) . '_Model';
        
        $path = APP_BASE . 'models/' . $model . '.php';
        
        if(file_exists($path)) {
            include_once $path;
            
            if(class_exists($u)) {
                $model = new $u;
            }
        }
        
        return $model;
    }
}