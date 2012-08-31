<?php defined('IN_APP') or die('Get out of here');

class Main_controller extends Controller {
    public function __construct() {
        parent::__construct();
        
        //  Set template data
        $this->template->set(array(
            'language' => Config::get('language'),
            'title' => 'Hiya, world.',
            'heading' => 'Howdy, world!',
            'route' => $this->routes
        ));
		
		
        echo $this->template->render();
        
        echo Request::post('https://chart.googleapis.com/chart', array(
        	'cht' => 'lc',
        	'chtt' => 'This is a test',
        	'chs' => '200x300',
        	'chxt' => 'x,y',
        	'chd' => 't:40,20,30,20,100'
        ));
    }
    
    public function index() {
        //echo 'index';
    }
    
    public function help() {
        //echo 'test';
    }
}