<?php defined('IN_APP') or die('Get out of here');

class Model {
	public $routes;
	
	public function __construct() {
		global $scaffold;
		$classes = $scaffold->classes();
		
		$this->routes = $scaffold->objects['routes'];
		
		//  Sanity check
		if(!isset($classes->database)) {
			return;
		}
		
		$this->db = $classes->database;
		
		if(get_called_class() === __CLASS__) {
			$this->_loadModel();
		}
	}
	
	public function _loadConfig() {
		$config = $this->db->select('*')->from('config')->fetch();
		
		//  Always return an array
		if($config === false) return array();
		
		//  And convert into a key->value array
		$return = array();
		foreach($config as $obj) {
			$return[$obj->key] = $obj->value;
		}
		
		return $return;
	}
	
	private function _loadModel() {
		$model = $this->routes->parse();
		$u = ucfirst($model[0]) . '_model';
		
		$path = APP_BASE . 'models/' . $model[0] . '.php';
		
		if(file_exists($path)) {
			include_once $path;
			
			if(class_exists($u)) {
				$model = new $u;
			}
		}
		
		return $model;
	}
}