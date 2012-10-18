<?php defined('IN_APP') or die('Get out of here');

class Main_controller extends Controller {
    public function __construct() {
        parent::__construct();
        
        $this->helper->load(array('lkdto', 'crush'));
        
        echo Crush::css("/*
            This is just the core CSS used in Scaffold's default views.
            You're more than welcome to delete this.
        */
        
        * {
            margin: 0;
            padding: 0;
            
            -webkit-font-smoothing: antialiased;
        }
        
        html, body {
            height: 100%;
        }
            body {
                background: #f7f5f0 url('../img/scaffold-logo.png') fixed no-repeat 40px 40px;
                color: #6d6054;
                
                font: 15px/25px 'Proxima Nova', sans-serif;
                
                width: 70%;
                margin: 100px auto;
            }
            
        p {
            padding-bottom: 15px;
        }");
        
        /*
        Cache::create('main.txt', array(
            'content' => 'hello world',
            'profile' => 'main_controller'
        ));
        */

        Cache::clear('main.txt');

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
        	'users' => $this->model->testSum(),
        	'edit' => $this->model->editUser()
        ));
        
        echo $this->template->render('main');
    }
    
    public function help() {
        echo 'test';
    }
}