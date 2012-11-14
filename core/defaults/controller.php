<?php defined('IN_APP') or die('Get out of here');

class Controller {
	public function __construct() {
		global $scaffold;
		
		foreach($scaffold->classes() as $name => $class) {
			$this->{$name} = $class;
		}
		
		if(get_called_class() === __CLASS__) {
			//  Grab the default model
			include_once CORE_BASE . 'defaults/model.php';
			
			//  Load the controller
			$this->_load('controller');
		}

		//  And call the model
		$this->defaultModel = new Model;
		$this->model = $this->_load('model');
		
		$this->helper->load('pages');
	}
	
	private function _load($what) {
		$routes = $this->routes->parse();

		$class = false;
		$u = ucfirst($routes[0]) . '_' . $what;
		
		$path = APP_BASE . $what . 's/' . $routes[0] . '.php';
		
		if(file_exists($path)) {
			include_once $path;
			
			if(class_exists($u)) {
				$class = new $u;
				
				//  Call the methods
				$method = isset($routes[1]) ? $routes[1] : Config::get('default_method', false);
				if($method && method_exists($class, $method)) {
					$class->{$method}();
				}
			}
		}
		
		return $class;
	}
}