<?php defined('IN_APP') or die('Get out of here');

class Main_controller extends Controller {
	public function __construct() {
		parent::__construct();

		//  Set template data
		$this->template->set(array(
			'heading' => 'test',
			'hello' => 'world'
		));
	}
	
	public function index() {
		$this->template->render('main');
	}
}