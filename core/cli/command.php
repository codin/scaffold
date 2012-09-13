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
        $arg = $this->arg(1, 'help');
    
        if($arg === 'help') {
            return $this->help();
        }
    
        $path = CORE_BASE . 'cli/tasks/' . $arg . '/' . $arg . '.php';
        $c = ucfirst($this->arg(1));
        
        if(!file_exists($path)) {
            $path = str_replace($arg, '_error', $path);
            $c = __CLASS__ . '_error';
        }
        
        include_once $path;
        $this->task = new $c;
        
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
}