<?php defined('IN_APP') or die('Get out of here');

class Curl_controller extends Controller {
    public function __construct() {
        parent::__construct();
        
        //  Set template data
        $this->template->set(array(
            'language' => Config::get('language'),
            'title' => 'CURL BITCH',
            'heading' => 'CURL BITCH',
            'route' => $this->routes
        ));
		
		
        echo $this->template->render();
       	
    }
    
    public function index() {
        //echo 'index';
    }
    
    public function help() {
        //echo 'test';
    }
}