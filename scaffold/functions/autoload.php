<?php 

/**
 *   Scaffold, a tiny PHP webapp framework.
 *
 *   @author	Codin' Co. <hi@codin.co>
 *   @version	2.0.0-alpha
 *   @package	Scaffold
 *
 *   Autoload any file, function, or elsewise.
 */
 
/**
 *   Auto-include every utility function
 */
foreach(glob('scaffold/functions/*.php') as $file) {
	include_once $file;
}
 
/**
 *   Try to autoload any functions
 *
 *   @param		$str	a string containing the namespaced class name
 *	 @usage		none	auto-called by PHP
 */
spl_autoload_register(function($str) {
	$str = str_replace(FRAMEWORK, FRAMEWORK . '/classes', $str);
	
	//  Make lowercase
	$str = strtolower($str);
	
	//  Make backslashes other-wayslashes
	$str = str_replace('\\', '/', $str);
		
	//  And include the file, if it exists
	$path = $str . '.php';
	
	if(file_exists($str . '.php')) {
		return include $str . '.php';
	}
});