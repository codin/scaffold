<?php !defined('IN_APP') and header('location: /');

class Scaffold {

    public $data;
    public $config;
    
    public function __construct($config, $classes) {
        //  Set the config
        $this->config = $config;
        
        //  Core classes
        $this->data = load_classes($classes, array('config' => $config));
    }
    
    public function classes() {
        return $this->data;
    }
}