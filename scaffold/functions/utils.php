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
 
 
/**
 *   Retrieve a list of options as an array or string.
 *   If a string, try to find the file/directory it's in.
 */
function options($var, $extension = '.php') {
	//  If it's an array, just give it back.
	if(is_array($var)) {
		return $var;
	}

	return files($var, $extension);
}

/**
 *   Search a directory or use a filename to retrieve a list of files.
 */
function files($var, $extension = '.php') {
	$length = -strlen($extension);
	$return = array();
	
	//  If it's one file, just return that
	if(substr($var, $length) == $extension) {
		return include $var;
	}
	
	foreach(glob(rtrim($var) . '/*' . $extension) as $file) {
		//  Remove directories and extensions
		$key = substr(basename($file), 0, $length);
				
		//  Add to the return array
		$return[$key] = files($file);
	}
	
	return $return;
}