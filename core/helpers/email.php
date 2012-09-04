<?php !defined('IN_APP') and header('location: /');

class Email {
    public $to;
    
    public static function send($to, $subject, $content) {
        
    }
    
    private function _sendPostmark($to, $subject, $content) {
        return $to . $subject . $contact;
    }
}