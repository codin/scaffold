<?php !defined('IN_APP') and header('location: /');

class Command {
    public $args;
    private $_base;
    
    public function __construct($args = array()) {
        $this->_base = CORE_BASE . 'cli/tasks/';
        
        //  Only allow alphanumeric arguments
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
        $arg = $this->arg(1, 'help');
    
        if($arg === 'help') {
            return $this->help();
        }
    
        //  Get the file's name
        $file = json_decode(file_get_contents($this->_base . $arg . '/meta.json'));
        $file = isset($file->file) ? $file->file : $arg . '.php';
        $path = $this->_base . $file;
        
        //  Get the class name
        $c = ucfirst($this->arg(1));
        
        //  Handle missing helpers
        if(!file_exists($path)) {
            return $this->error($path);
        }
        
        //  Get the file
        include_once $path;
        $this->task = new $c($this->arg(1));
        
        echo $this->task->run($this->arg(2), $this->arg(3), $this->arg(4));
    }
    
    public function help() {
        $help = array();
        
        echo 'To run a Scaffold command, just run one of the commands below in the following format:' . PHP_EOL;
        echo './scaffold [command] [optional parameters]'. PHP_EOL . PHP_EOL;
        
        foreach(glob(CORE_BASE . 'cli/tasks/*/meta.json') as $file) {
            $json = json_decode(grab($file));
            if($json) {
                echo str_pad(strtolower(str_replace(' ', '-', $json->name)), 15);
                echo $json->description;
            }
        }
        
        echo PHP_EOL;
    }
    
    public function error($path) {
        echo $path . PHP_EOL;
    }
}