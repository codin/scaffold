<?php !defined('IN_APP') and header('location: /');

class Cli {
	
	public $arg, $method, $methods;
	
	public function __construct($r, $methods) {
		// Set the method and arguments
		$this->method = $r[1];
		$this->arg = $r[2];
		$this->methods = $methods;
	}
	
	public function parse($r) {
		// if its one of our listed methods ...
		if(array_key_exists($this->method, $this->methods)) {
			$this->doOperation();
		} else {
			// show an error
			echo 'This operation does not exist: ' . $this->method . " Try one of the following. \n";
			
			// display all of the available operations
			foreach($this->methods as $key => $value) {
				echo $key . "\n";
			}
		}
	}
	
	public function doOperation() {
		if(is_callable($this->methods[$this->method])) {
			echo 'Doing operation: ' . $this->method . "\n";
			$this->methods[$this->method]($this->arg);
		} else {
			echo 'Unable to do operation: ' . $this->method;
		}
	}
}