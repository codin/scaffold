<?php !defined('IN_APP') && header('location: /');

class Error {
    public static $errors = array();
    
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