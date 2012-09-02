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
    }
    
    public function index() {
        $db = $this->model->allUsers();
        $this->template->set('db', $db);
        
        echo $this->template->render('main');
    }
    
    public function help() {
        echo 'test';
    }
}