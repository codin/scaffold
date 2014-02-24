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
 
namespace Scaffold\Http;

echo 'hello';

class Cookies extends \Scaffold\Helpers\Storage {
	/**
	 *   Store our default cookie parameters as an array
	 *   We can use this to look up our type when we set a cookie.
	 */
	public static $opts = array(
		'value' => null,
		'domain' => '',
		'path',
		'expires',
		'secure' => false,
		'httponly' => false
	);
	
	/**
	 *   Set a cookie.
	 *
	 *   @param		$key		A Scaffold-only key/session name.
	 *   @param 	$val		An array containing any options to store with our cookie.
	 */
	public static function set($key, $val) {
		$val = array_merge($this->opts, $val);
		
		return parent::set($key, $val);
	}
	
	/**
	 *   Get a cookie.
	 *
	 *   @param		$key		A Scaffold-only key/session name.
	 *   @param 	$fallback	An array containing data if no key is found.
	 */
	public static function get($key, $fallback) {
		return parent::get($key, array_merge($this->opts, $fallback));
	}
}