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
        
        echo Typography::enhance("Testing <code>var str = '';</code> a b c d e f g... -- --- This \"is\" '' a 'test', you know -- that cool ol' thing?");
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