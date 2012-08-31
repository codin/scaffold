<?php !defined('IN_APP') and header('location: /');

class Database {
    private $_config;
    private $_driver;
    private $_db;
    private $_queryCount;
    
    public $query;
    
    //  Set up the Database object
    public function __construct($data) {
        $this->_config = Config::get('database');
        $this->_driver = Config::get('database.driver', 'mysql');
        
        //  Set the default driver
        if(!extension_loaded('pdo_' . $this->_driver)) {
            $this->_driver = 'mysql';
        }
        
        //  And set PDO
        $this->_db = new PDO('mysql:host=' . $this->_config['host'] . ';dbname=' . $this->_config['name'] . ';port=' . $this->_config['port'], $this->_config['user'], $this->_config['pass']);
    }
    
    //  Start building our queries up
    public function select($what) {
        if($what !== '*') {
            $what = '\'' . $what . '\'';
        }
        
        return $this->set('select', $what);
    }
    
    public function from($where) {
        return $this->set('from', '`' . Input::escape($where) . '`');
    }
    
    public function where($condition) {
        if(is_array($condition)) {
            $return = '';
            foreach($condition as $key => $value) {
                $return .= '`' . $key . '` = \'' . $value . '\' and ';
            }
            
            $condition = substr($return, 0, -5);
        }
        
        return $this->set('where', $condition);
    }
    
    public function limit($from, $to = -1) {
        $limit = $to > 0 ? $from . ', ' . $to : $from;
        return $this->set('limit', $limit);
    }
    
    public function drop($table) {
        return $this->query('drop tables `' . Input::escape($table) . '`');
    }
    
    //  Add a key to the query string
    public function set($key, $val) {
        //  Set it
        $this->query[$key] = $val;
        
        //  And chain
        return $this;
    }
    
    public function fetch() {
        //  Default structures to query the DB
        $query = $this->_buildQuery();

        if(($result = $this->query($query))) {
            return $result->fetchAll(PDO::FETCH_OBJ);
        }
        
        return false;
    }
    
    public function query($what) {
        if($what) {
            return $this->_db->query($what);
        }
        
        return false;
    }
    
    private function _buildQuery() {
        $structures = array(
            'select' => array('from', 'where', 'order', 'limit'),
            'insert' => array('into', 'where'),
            'update' => array('set', 'where'),
            'delete' => array('from', 'where')
        );
        
        foreach($structures as $structure => $val) {
            if(isset($this->query[$structure])) {
                $query = $structure . ' ' . $this->query[$structure] . ' ';
                
                foreach($val as $step) {
                    if(isset($this->query[$step])) {
                        $query .= $step . ' ' . $this->query[$step] . ' ';
                    }
                }
                
                return trim($query);
            }
        }
        
        return false;
    }
}