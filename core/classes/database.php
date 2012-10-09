<?php !defined('IN_APP') and header('location: /');

class Database {
    private $_config;
    private $_driver;
    private $_db;
    private $_queryCount;
    
    public $query;
    public $latestQuery;
    public $queryCount;
    
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
	        $this->_db = new PDO(
	            $this->_driver . ':host=' . $this->_config['host'] . ';
	             dbname=' . $this->_config['name'] . ';
	             port=' . $this->_config['port'],
    	         
    	         $this->_config['user'],
    	         $this->_config['pass']
	         );
	    } catch(PDOException $e) {
	    	Error::grab($e);
	    }
    }
    
    //  Start building our queries up
    public function select($what) {
        if($what !== '*') {
            $what = '\'' . $what . '\'';
        }
        
        return $this->_set('select', $what);
    }
    
    public function update($what) {
	    if($what !== '*') {
	        $what = '`' . $what . '`';
	    }
	    
	    return $this->_set('update', $what);
    }
    
    public function insert() {
        $this->query['insert'] = '';
        return $this;
    }
    
    public function delete() {
    	$this->query['delete'] = '';
    	return $this;
    }
    
    public function into($table) {
    	return $this->_set('into', $table);
    }
    
    public function values($values) {
    	// add the first bracket
    	$value_string = '(';
    	
    	// concatenate
    	foreach($values as $key => $value) {
    		$value_string .= '\'' . Input::escape($value) . '\', ';
    	}
    	
    	// remove the last comma
    	return $this->_set('values', substr($value_string, 0, -2) . ')');
    }
    
    public function from($where) {
        return $this->_set('from', '`' . Input::escape($where) . '`');
    }
    
    public function where($condition) { 
        return $this->_set('where', $this->_buildCondition($condition));
    }
    
    public function limit($from, $to = -1) {
        $limit = $to > 0 ? $from . ', ' . $to : $from;
        return $this->_set('limit', $limit);
    }
    
    public function drop($table) {
        return $this->query('drop tables `' . Input::escape($table) . '`');
    }
    
    //  Add a key to the query string
    private function _set($key, $val) {
       	if($val) {
	        //  Set it
	        $this->query[$key] = $val;
	    }
        
        //  And chain
        return $this;
    }
    
    private function _buildCondition($condition) {
    	if(is_array($condition)) {
    	    $return = '';
    	    foreach($condition as $key => $value) {
    	    	$value = (is_numeric($value) ? $value : '\'' . Input::escape($value) . '\'');
    	        $return .= '`' . $key . '`=' . $value . ' and ';
    	    }
    	    
    	    return substr($return, 0, -5);
    	}
    	
    	return false;
    }
    
    public function set($condition) {
        return $this->_set('set', $this->_buildCondition($condition));
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
            $this->queryCount++;
            $this->latestQuery = $what;
            // reset the query
            $this->query = '';
            
            return $this->_db ? $this->_db->query($what) : false;
        }
        
        return false;
    }
    
    public function go() {
    	$query = $this->_buildQuery();
    	return $this->query($query);
    }
    
    private function _buildQuery() {
        $structures = array(
            'select' => array('from', 'where', 'order', 'limit'),
            'insert' => array('into', 'where', 'values'),
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
    
    public function latestQuery() {
        return $this->latestQuery;
    }
    
    public function queryCount() {
        return $this->queryCount;
    }
    
    public function escape($str, $stripHTML = false, $filter = FILTER_SANITIZE_STRING) {
        $str = htmlentities(filter_var($str, $filter));
        
        if($stripHTML === true) {
            $str = strip_tags($str);
        }
        
        return $str;
    }
}