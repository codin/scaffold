<?php defined('IN_APP') or die('Get out of here');

class Main_controller extends Controller {
    public function __construct() {
        parent::__construct();
        
        $this->helper->load('lkdto');
        
        Cache::create('main.txt', array(
            'content' => 'hello world',
            'profile' => 'main_controller'
        ));

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
        $this->template->set('db', array(
        	'users' => $this->model->allUsers(),
        	'edit' => $this->model->editUser()
        ));
        
        echo $this->template->render('main');
    }
    
    public function help() {
        echo 'test';
    }
}