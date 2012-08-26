<?php !defined('IN_APP') and header('location: /');

class Error {
    public static $errors = array();
    
    //  Set up our error reporting
    public static function init() {
        $errors = Config::get('env.debug');
        
        if(!$errors) {
            @ini_set('display_errors', false);
        }

        //error_reporting(Config::get('env.error_level', -1));
        error_reporting(0);
    }
    
    public static function exception($e) {
        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
        include_once CORE_BASE . 'defaults/error.php';
    }
    public static function native($e) {
        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
        include_once CORE_BASE . 'defaults/error.php';
    }
    public static function shutdown($e = '') {
		$trace = debug_backtrace();
//		$contexts = static::context($file, $e->getLine());
		
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
    
    public static function output() {
        return self::$errors;
    }
}