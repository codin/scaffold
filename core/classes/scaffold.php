<?php !defined('IN_APP') && header('location: /');

class Scaffold {
    
    public function __construct($data) {
        global $config;
                
        foreach($data as $class) {
            $u = ucfirst($class);
            if(class_exists($u)) {
                $this->{$class} = new $u($config);
            }
        }

        $this->helper->load('test');
    }
}