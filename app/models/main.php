<?php defined('IN_APP') or die('Get out of here');

class Main_model extends Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function allUsers() {
        return $this->db->select('*')->from('test')->fetch();
    }
    
    public function editUser() {
    	return $this->db->update('test')->set(array('name' => 'hello'))->where(array('id' => 2))->go();
    }
    
    public function insert($what) {
    	return $this->db->insert()->into('test')->values(array('null', $what))->go();
    }
    
    public function delete() {
    	return $this->db->delete()->from('test')->where(array('id' => 3))->go();
    }
}