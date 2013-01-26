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
		
		error_reporting(Config::get('env.error_level', E_ALL));
	}
	
	private static function _trace($arg = false) {
		$backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
		
		if($arg === true and isset($backtrace['args']['0'])) {
			self::log($backtrace['args']['0']);
		}
		
		return $backtrace;
	}
	
	public static function exception($err, $message, $file, $line) {
		return self::_throw();
	}
	
	public static function native($err, $message, $file, $line) {				
		return self::_throw();
	}
	
	public static function shutdown() {
		return self::_throw();
	}
	
	private static function _throw() {
		return fetch(CORE_BASE . 'defaults/error.php', self::_trace());
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
	
	public static function create($msg, $type = E_USER_NOTICE) {
		
		if(in_array($type, Config::get('error.levels'))) {
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