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
        
        $this->validator->ensure('iam@visualidiot.com')
                        ->is(':email')
                        ->lessThan(40)
                        ->has('a');
        
        var_dump($this->validator->hasErrors());
       
        // bitch this works
        $email = new Email();
        dump($email->to('childscraig17@gmail.com')->subject('test')->body(htmlentities("<b>Hello</b>"))->send());
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