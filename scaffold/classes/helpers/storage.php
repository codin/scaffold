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

	public static function set($key, $val) {
		return $val;
	}
	
	public static function get($key, $fallback) {
		return $fallback;
	}
}