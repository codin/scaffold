<?php !defined('IN_APP') and header('location: /');

class Command {
    public $args;
    
    public function __construct($args = array()) {
        foreach($args as $arg) {
            $this->args[] = preg_replace('/[^A-Za-z0-9\-_]+/', '', $arg);
        }
    }
    
    public function arg($index, $fallback = '') {
        if(isset($this->args[$index])) {
            return $this->args[$index];
        }
        
        return $fallback;
    }
    
    public function run() {
        $path = CORE_BASE . 'cli/tasks/' . $this->arg(1) . '.php';
        $c = ucfirst($this->arg(1));
        
        if(!file_exists($path)) {
            $path = str_replace($this->arg(1), '_error', $path);
            $c = 'Error';
        }
        
        include_once $path;
        $this->task = new $c;
        
        echo $this->task->run($this->arg(2), $this->arg(3), $this->arg(4));
    }
}