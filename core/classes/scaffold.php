<?php !defined('IN_APP') and header('location: /');

class Scaffold {

	public $data;
	public $config;
	public $classes, $classPath;
	
	public function __construct($config, $classes, $dependants) {		
		//  Set the config
		$this->config = $config;

		// Set the default class path
		$this->classPath = CORE_BASE . "classes/";
		
		//  Core classes
		$this->classes = $classes;
		
		//  Load our classes
		$this->loadClasses();

		// Then load our dependants
		$this->loadClasses($dependants, $this->classPath . 'dependants/');
		
		//  Set our model up
		Storage::set('db', $this->objects['database']);
		$this->objects['model'] = $this->bind('model');
		
		//  Save the model for the controller
		Storage::set('objects', $this->objects);
		
		//  And go
		return $this->bind('controller');
	}
	
	public function bind($what) {
		$routes = $this->objects['routes']->parse();
		
		//  Include the default class that gets extended
		include_once CORE_BASE . 'defaults/' . $what . '.php';

		//  Store our class names
		$class = false;
		$u = ucfirst($routes[0]) . '_' . $what;
		
		//  The path to the routed controller/model
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
	
	public function loadClasses($list = null, $p = false) {
		if($list == null) {
			$list = $this->classes;
		}

		if(!$p) {
			$p = $this->classPath;
		}

		foreach($list as $class) {
			$path = $p . preg_replace('/(\/.*)/', '', $class) . '.php';
			if(file_exists($path)) {
				include_once $path;

				$u = ucfirst($class);
				if(class_exists($u)) {				

					//  Handle static instances
					//  We label them by using the method "init"
					if(method_exists($u, 'init')) {
						$this->data->{$class} = call_user_func_array($u . '::init', array($this));
					}

					$this->data->{$class} = new $u($this->config);
					$this->objects[$class] = $this->data->{$class};
				}
			}
		}
	}
	
	public function classes() {
		return $this->data;
	}
}