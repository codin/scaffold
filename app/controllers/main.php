<?php defined('IN_APP') or die('Get out of here');

class Main_controller extends Controller {
    public function __construct() {
        parent::__construct();
        
        var_dump($this);
        
        //  Set template data
        $this->template->set(array(
            'language' => Config::get('language'),
            'title' => 'Hiya, world.',
            'test' => 'This is a just a test.'
        ));

        //  Oh wait, this is totally an AJAX request
        $this->ajax->output(array(
            'content' => $this->template->render() . load_time()
        ));
    }
    
    public function index() {
        //echo 'index';
    }
}