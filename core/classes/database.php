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
			$connection = $this->_driver . ':host=' . $this->_config['host'] . ';dbname=' . $this->_config['name'] . ';port=' . $this->_config['port'];
			 
			$this->_db = new PDO($connection, $this->_config['user'], $this->_config['pass'], array(
				PDO::ATTR_PERSISTENT => true
			));
			
			$this->_db->exec('set character set utf8');
		} catch(PDOException $e) {
			Error::grab($e);
		}
	}
	
	//  Start building our queries up
	public function select($what, $quotes = true) {
		if($what !== '*' and $quotes === true) {
			$what = '`' . $what . '`';
		}
		
		return $this->_set('select', $what);
	}
	
	public function update($what) {
		if($what !== '*') {
			$what = '`' . $what . '`';
		}
		
		return $this->_set('update', $what);
	}
	
	public function insert($into = false) {
		$this->query['insert'] = '';
		
		if($into !== false) {
			return $this->into($into);
		}
		
		return $this;
	}
	
	public function delete() {
		$this->query['delete'] = '';
		return $this;
	}

	public function sum($column) {
		$this->query['select'] .= ', ';
		return $this->_set('sum', '(' . $column . ')');
	}

	public function max($column) {
		$this->query['select'] .= ', ';
		return $this->_set('max', '(' . $column . ')');
	}

	public function min($column) {
		$this->query['select'] .= ', ';
		return $this->_set('min', '(' . $column . ')');
	}

	public function avg($column) {
		$this->query['select'] .= ', ';
		return $this->_set('avg', '(' . $column . ')');
	}

	public function format($column, $format) {
		$this->query['select'] .= ', ';
		return $this->_set('format', '(' . $column . ', ' . $format . ')');
	}

	public function storeAs($name) {
	   return $this->_set('as', '"' . $name . '"');
	}

	public function group($what = '') {
		return $this->_set('group', $what ? 'by `' . $what . '`' : '');
	}

	public function count() {
		$this->query['select'] = 'count(' . $this->query['select'] . ')';
		return $this;
	}
	
	public function by($field) {
		return $this->_set('by', $field);
	}

	public function into($table) {
		return $this->_set('into', $table);
	}
	
	public function values($values) {
		$val = '(';
		
		foreach($values as $key => $value) {
			$val .= '\'' . Input::escape($value) . '\', ';
		}
		
		//  Remove the last comma
		return $this->_set('values', substr($val, 0, -2) . ')');
	}
	
	public function from($where) {
		return $this->_set('from', '`' . Input::escape($where) . '`');
	}
	
	public function where($condition) {
		$return = '';
		$parts = array();

		foreach($condition as $key => $value) {
			$return .= $this->_buildCondition(array($key => Input::escape($value))) . (count($condition) > 1 ? ' and ' : '');
		}

		if(strpos($return, 'and') !== false) {
			$return = substr($return, 0, -5);
		}

		return $this->_set('where', $return);
	}
	
	public function limit($from, $to = -1) {
		$limit = $to > 0 ? $from . ', ' . $to : $from;
		return $this->_set('limit', $limit);
	}
	
	public function order($what) {
		return $this->_set('order', 'by ' . $what);
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
	
	private function _buildCondition($condition, $escape = true) {
		if(is_array($condition)) {
			$return = ' ';
			foreach($condition as $key => $value) {
				$operator = '`';

				if(strpos($value, '>') !== false or strpos($value, '<') !== false) {
					$operator = '` ' . substr($value, 0, 1);
					$value = substr($value, 1, strlen($value));
				}

				$value = (is_numeric($value) ? $value : '\'' . ($escape ? Input::escape($value) : $value) . '\'');
				$return .= '`' . $key . $operator . '= ' . $value . ' and ';
			}
			
			return substr($return, 0, -5);
		}
		
		return false;
	}
	
	public function set($condition, $escape = true) {
		return $this->_set('set', $this->_buildCondition($condition, $escape));
	}
	
	public function fetch($limit = false) {
		if($limit !== false) {
			$this->limit($limit);
		}
	
		//  Default structures to query the DB
		$query = $this->_buildQuery();
		
		if(($result = $this->query($query))) {
			return $result->fetchAll(PDO::FETCH_OBJ);
		}

		return $this->query($query);
	}
	
	public function query($what) {
		$this->query = array();

		if($what and $this->_db) {
			$this->queryCount++;
			$this->latestQuery = $what;
			
			return $this->lastQuery = $this->_db->query($what);
		}

		return false;
	}
	
	public function go() {
		return $this->query($this->_buildQuery());
	}
	
	private function _buildQuery() {
		$structures = array(
			'select' => array('sum', 'max', 'min', 'avg', 'format', 'as', 'from', 'where', 'group', 'by', 'order', 'limit'),
			'insert' => array('into', 'where', 'values'),
			'update' => array('set', 'where'),
			'delete' => array('from', 'where')
		);
		
		foreach($structures as $structure => $val) {
			if(isset($this->query[$structure])) {
				$query = $structure . ' ' . $this->query[$structure] . ' ';
				
				foreach($val as $step) {
					if(isset($this->query[$step])) {
						$query .= $step;
							switch($step) {
								case 'sum':
									$query .= '';
									break;
								case 'max':
									$query .= '';
									break;
								case 'min':
									$query .= '';
									break;
								case 'avg':
									$query .= '';
									break;
								case 'format':
									$query .= '';
									break;
								default:
									$query .= ' ';
							}
						$query .= $this->query[$step] . ' ';
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