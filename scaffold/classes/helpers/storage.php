<?php 

/**
 *   Scaffold, a tiny PHP webapp framework.
 *
 *   @author	Codin' Co. <hi@codin.co>
 *   @version	2.0.0-alpha
 *   @package	Scaffold
 *
 *   Here goes nothin’.
 */
 
namespace Scaffold\Helpers;

class Storage extends Helpers {
	/**
	 *   @var	$data		store our Storage items here
	 */
	public static $data = array();

	/**
	 *   Add an item to storage.
	 *
	 *   @var	$key		A string of the key to store. You can
	 *						use a dot to denote child-levels.
	 *   @var	$val		Whatever you want to store. This can be
	 *						any type of variable.
	 */
	public static function set($key, $val) {
		return self::$data[$key] = $val;
	}
	
	
	/**
	 *   Get an item from storage.
	 *
	 *   @var	$key		A string of the key to store. You can
	 *						use a dot to denote child-levels.
	 *   @var	$val		Whatever you want to store. This can be
	 *						any type of variable.
	 */
	public static function get($key, $fallback = false) {
		if(isset(self::$data[$key])) {
			return self::$data[$key];
		}
		
		return $fallback;
	}
}