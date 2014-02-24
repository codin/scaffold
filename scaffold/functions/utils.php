<?php 

/**
 *   Scaffold, a tiny PHP webapp framework.
 *
 *   @author	Codin' Co. <hi@codin.co>
 *   @version	2.0.0-alpha
 *   @package	Scaffold
 *
 *   Functions used by Scaffold that don't really fit in anywhere else.
 */
 
function options($var) {
	if(is_array($var)) {
		return $var;
	}
	
	$file = rtrim($var, ' /');
	$array = array();
	
	foreach(glob($file) as $file) {
		if(is_file($file) and file_exists($file)) {
			$array[] = include $file;
		}
	}
	
	return $array;
}