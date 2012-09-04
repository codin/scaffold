<?php !defined('IN_APP') and header('location: /');

class Error {
    public static $errors = array();
    
    //  Set up our error reporting
    public static function init() {
        $errors = Config::get('env.debug');
        
        if(!$errors) {
            @ini_set('display_errors', false);
        }

        error_reporting(E_ALL);
//        error_reporting(Config::get('env.error_level', -1));
//        error_reporting(0);
    }
    
    public static function exception($err, $message, $file, $line) {
        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
        include_once CORE_BASE . 'defaults/error.php';
    }
    
    public static function native($err, $message, $file, $line) {                
        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
        include_once CORE_BASE . 'defaults/error.php';
    }
    
    public static function shutdown() {
		$trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
		if(empty($trace['args'])) return false;
        include_once CORE_BASE . 'defaults/error.php';
    }
    
    public static function log($what) {
        $now = microtime(true);
        $error = array(
            'at' => $now,
            'message' => $what,
            'stack_trace' => debug_backtrace(true)
        );
        
        self::$errors[] = $error;
        
        return (object) $error;
    }
    
    public static function grab($ex) {
    	$trace = $ex->getTrace();
    	$message = $ex->getMessage();
    	$line = $ex->getLine();
    	$file = $ex->getFile();
        include_once CORE_BASE . 'defaults/error.php';
    }
    
    public static function output() {
        return self::$errors;
    }
}