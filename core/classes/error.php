<?php !defined('IN_APP') and header('location: /');

class Error {
    public static $errors = array();
    
    public static $WARNING = E_USER_WARNING,
    			  $NOTICE = E_USER_NOTICE,
    			  $FATAL = E_USER_ERROR;
    
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
       	self::log($trace['args']['0']);
        include_once CORE_BASE . 'defaults/error.php';
    }
    
    public static function native($err, $message, $file, $line) {                
        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
       	self::log($trace['args']['0']);
        include_once CORE_BASE . 'defaults/error.php';
    }
    
    public static function shutdown() {
		$trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
		if(empty($trace['args'])) return false;
		self::log($trace['args']['0']);
        include_once CORE_BASE . 'defaults/error.php';
    }
    
    public static function log($what) {
        $now = microtime(true);
        $error = array(
            'at' => $now,
            'message' => $what,
            'stack_trace' => first(debug_backtrace(true))
        );
        
        self::$errors[] = $error;
        
        $log = 'ERROR: ' . $what . ' at ' . $now . ' in ' . $error['stack_trace']['file'] . ' on line ' . $error['stack_trace']['line'] . "\n";
        
        File::write('error.txt', $log, true, CORE_BASE . 'logs/');
        
        return (object) $error;
    }
    
    public static function grab($ex) {
    	$trace = $ex->getTrace();
    	$message = $ex->getMessage();
    	$line = $ex->getLine();
    	$file = $ex->getFile();
        include_once CORE_BASE . 'defaults/error.php';
    }
    
    public static function create($msg, $type) {
    	
    	if(in_array($type, Config::get('error.handled'))) {
    		// Throw an actual error.
    		$callee = first(debug_backtrace());
    		trigger_error($msg . ' in <strong>' . $callee['file'] . '</strong> on line <strong>' . $callee['line'] . "</strong>.\n<br> Thrown", $type);
    		self::log($msg);
    		return true;
    	}
    	
    	return false;
    }
    
    public static function output() {
        return self::$errors;
    }
}