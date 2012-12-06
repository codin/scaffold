<?php defined('IN_APP') or die('Get out of here');

class Model {
	public $routes;
	
	public function __construct() {
		$object = Storage::get('db', false);
		
		//  Sanity check
		if($object === false) {
			return Error::log('Could not get Database class');
		}
		
		$this->db = $this->database = $object;
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