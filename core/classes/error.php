<?php !defined('IN_APP') && header('location: /');

class Error {
    public static $errors = array();
    
    //  Set up our error reporting
    public static function init() {
        $errors = Config::get('env.debug');
        
        if($errors) {
            @ini_set('display_errors', false);
        }

        error_reporting(Config::get('env.error_level', -1));
    }
    
    public static function log($what) {
        $now = microtime(true);
        $error = array(
            'at' => $now,
            'message' => $what,
            'stack_trace' => debug_backtrace(true)
        );
        
        $errors[] = $error;
        
        return (object) $error;
    }
    
    public static function output() {
        return self::$errors;
    }
}