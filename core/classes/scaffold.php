<?php !defined('IN_APP') && header('location: /');

class Scaffold {
    
    public function __construct($data) {
        foreach($data['classArray'] as $class) {
            $u = ucfirst($class);
            if(class_exists($u)) {
                $this->{$class} = new $u($data['config']);
            }
        }

        echo $this->routes->parse();
    }
}