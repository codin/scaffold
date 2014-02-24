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
 
namespace Scaffold\Helpers;

class File {
	public static function remove($file) {
		//  If we can write to it, we can delete it.
		if(is_file($file) and is_writable($file)) {
			unlink($file);
		}
	}
}