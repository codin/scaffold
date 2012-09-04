<?php defined('IN_APP') or die('Get out of here');

class Main_controller extends Controller {
    public function __construct() {
        parent::__construct();
        
        //  Set template data
        $this->template->set(array(
            'language' => Config::get('language'),
            'title' => 'Hiya, world.',
            'heading' => 'Howdy, world!',
            'route' => $this->routes,
            
            'query_count' => $this->database->queryCount()
        ));
    }
    
    public function index() {
        $db = (object) array(
        	'users' =>	$this->model->allUsers(),
        	'edit' => $this->model->editUser()
        );
        
        $this->template->set('db', $db);
        echo $this->template->render('main');
    }
    
    public function help() {
        echo 'test';
    }
}