<?php 

/**
 *   Scaffold, a tiny PHP webapp framework.
 *
 *   @author	Codin' Co. <hi@codin.co>
 *   @version	2.0.0-alpha
 *   @package	Scaffold
 *
 *   Simple page caching.
 */
 
namespace Scaffold\Cache;

class Cache {
	private static $path = 'scaffold/classes/cache/store/';
	
	public static function load($url) {
		
	}
	
	public static function refresh($url) {
	
	}
	
	public static function clear() {
		foreach(glob(self::$path . '*') as $file) {
			\Scaffold\Helpers\File::remove($file);
		}
	}
}