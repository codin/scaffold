<?php !defined('IN_APP') && header('location: /');

class Email {
    public $to;
    
    private function _sendPostmark($to, $subject, $content) {
        return $to . $subject . $contact;
    }
}