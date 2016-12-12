<?php defined('IN_APP') or die('Get out of here');

class Test {
	public static function hello() {
		dump('hello');
	}

	public function __construct() {
		dump('constructing the test helper');
	}

	public function world() {
		dump('world');
	}
}