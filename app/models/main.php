<?php defined('IN_APP') or die('Get out of here');

class Main_model extends Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function allUsers() {
        return $this->db->select('*')->from('users')->where(array(
            'username' => 'vi'
        ))->limit(0, 30)->fetch();
    }
}