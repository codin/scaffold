<?php defined('IN_APP') or die('Get out of here');

class Model {
	public $routes;
	
	public function __construct() {
		$objects = Storage::get('objects');
		
		//  Sanity check
		if(!isset($objects->database)) {
			return Error::log('Could not get Database class');
		}
		
		$this->db = $objects->database;
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
}