<?php defined('IN_APP') or die('Get out of here');

class Controller {
	public function __construct() {
		foreach(Storage::get('objects') as $name => $class) {
			$this->{$name} = $class;
		}
		
		//  Set the default config from the database
		if(Config::get('autoload_config') === true and method_exists($this->model, '_loadConfig')) {
			foreach($this->model->_loadConfig() as $key => $value) {
				Config::set($key, $value);
			}
		}
	}
}