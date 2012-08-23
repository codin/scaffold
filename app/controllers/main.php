<?php defined('IN_APP') or die('Get out of here');

class Main_controller {
    public function __construct() {
        //  THIS SUCKS SO BAD
        //  Should be $this->template->set(array()), etc.
        $template = new Template;
        $template->set(array(
            'language' => Config::get('language'),
            'title' => 'Hiya, world.',
            'test' => 'This is a just a test.'
        ));

        //  Oh wait, this is totally an AJAX request
        $ajax = new Ajax;
        $ajax->output(array(
            'content' => $template->load()
        ));
    }
    
    public function index() {
        //echo 'index';
    }
}