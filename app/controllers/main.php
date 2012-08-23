<?php defined('IN_APP') or die('Get out of here');

class Main_controller {
    public function __construct() {
        //  THIS SUCKS SO BAD
        $template = new Template;
        $template->set('language', Config::get('language'));
        $template->set('title', 'Hello, World!');
        $template->set('test', 'Testing the Template class');

        echo $template->load('main');
        
        dump(File::get('test.txt'));
    }
}