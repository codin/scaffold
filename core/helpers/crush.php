<?php !defined('IN_APP') and header('location: /');

class Crush {
    /*
        Crush::css('* {
            content: 'look how much CSS I'm wasting!';
        }');
        
    */
    public function css($str) {
        //  Strip comments
        $str = preg_replace_callback('/(\/\*)(.*)(\*\/)/', function($matches) {
            var_dump($matches);
        }, $str);
    
        return trim($str);
    }
}