<?php !defined('IN_APP') and header('location: /');

class Validator {
	private $_errors = array();
	private $_target;
	
	/**
	 *  Start the validation engine
	 *  @param (string) $what
	 */
	public function ensure($what) {
		$this->_target = $what;
		
		return $this;
	}
	
	/**
	 *  Check explicit equality
	 */
	public function is($what, $message = null) {
		//  Check we're not trying to use custom methods
		if(strpos($what, ':') !== false) {
			$class = 'is' . ucfirst(str_replace(':', '', $what));
			
			if(method_exists(__CLASS__, $class)) {
				return $this->{$class}($message);
			}
		}
		
		return $this->addCheck($this->_target == $what, $message);
	}
	
	/**
	 *  Check for a lack of explicit equality
	 */
	public function not($what, $message = null) {
		return $this->addCheck(!$this->is($what), $message);
	}
	
	/**
	 *  Check if it's an email
	 *  @param (string) $email	  The suspected email address
	 *  @param (string) $message	The error message to show if not
	 */
	public function isEmail($message = null) {
		return $this->addCheck(filter_var($this->_target, FILTER_VALIDATE_EMAIL) !== false, $message);
	}
	
	/**
	 *  Check the existence of a substring
	 */
	public function has($what, $message = null) {
		return $this->addCheck(strpos($this->_target, $what) !== false, $message);
	}
	
	/**
	 *  Check the lack of existence within a substring
	 */
	public function hasNo($what, $message = null) {
		return $this->addCheck(!$this->has($what), $message);
	}
	
	/**
	 *  Check if it's a number, and less than something
	 *  @param (string) $num		The number to check if it's smaller than
	 *  @param (string) $message	The error message to show if not
	 */
	public function lessThan($num, $message = null) {
		return $this->addCheck($this->_target < $num, $message);
	}
	
	/**
	 *  Add the check to the list
	 */
	public function addCheck($what, $message = 'Invalid.') {
		if($what === false) {
			if(!$message) {
				$trace = debug_backtrace();
				$arg = $trace[1]['args'][0];
				$trace = $trace[1]['function'];
			}
			
			$this->_errors[] = $message ? $message : 'Could not validate &ldquo;' . $trace . '(' . $arg . ')&rdquo; on ' . $this->_target . '.';
		}
		
		return $this;
	}
	
	/**
	 *  Check if any errors were generated
	 */
	public function errors() {
		return $this->_errors;
	}
	
	/**
	 *  Return an error count
	 */
	public function hasErrors() {
		return count($this->_errors) > 0;
	}
}