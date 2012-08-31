<?php !defined('IN_APP') and header('location: /');

class Database {
    private $_config;
    private $_driver;
    private $_db;
    
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
        try {
            $this->_db = new PDO('mysql:host=' . $this->_config['host'] . ';dbname=' . $this->_config['name'] . ';port=' . $this->_config['port'], $this->_config['user'], $this->_config['pass']);
        } catch(Exception $e) {
            Error::log('PDO could not be set');
        }
    }
    
    //  Start building our queries up
    public function select($what) {
        return $this->set('select', $what);
    }
    
    public function where($a) {
        return $this->set('where', $a);
    }
    
    //  Add a key to the query string
    public function set($key, $val) {
        //  Set it
        $this->query[$key] = $val;
        
        //  And chain
        return $this;
    }
    
    public function fetch() {
        echo join(' ', $this->query);
    }
}