<?php defined('IN_APP') or die('Get out of here');

/**
 *	Scaffold v0.1.1
 *	by the Codin' Co.
 *
 *	Here lies the basic bootstrapper, which instantiates all the classes and loads
 *	all of the files up properly. Here goes!
 */

/* Comment out the line below if you wish to display errors (Overrides error class) */
error_reporting(0);

//  Strip magic quotes if it's enabled
if(function_exists('get_magic_quotes_gpc') and get_magic_quotes_gpc()) {
	$magics = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);

	foreach($magics as &$method) {
		array_walk_recursive($method, function(&$value) {
			$value = stripslashes($value);
		});
	}
}

//  Set the default timezone to London if you don't have any set
if(!ini_get('date.timezone')) {
	date_default_timezone_set('Europe/London');
}

//  Load local environment variables
$env = getenv('scaffold_env');

//  Load the rest of the config
$config = array();
$files = array('template', 'environment', 'language', 'routes', 'database', 'misc', 'crypt', 'session', 'file', 'csrf', 'email', 'error', 'image', 'cache');

//  Try loading the config files
//  If they don't work, log to an array for now

//  Get our badFiles array ready
$badFiles = array();

//  Loop all the config files to check they're good
foreach($files as $file) {
	$filename = BASE . 'config/' . $file . '.php';

	if($env !== false and file_exists(BASE . 'config/' . $file . '.' . $env . '.php')) {
		$filename = BASE . 'config/' . $file . '.' . $env . '.php';
	}

	if(file_exists($filename)) {
		$config[] = $file;
		include $filename;
	} else {
		$badFiles[] = $filename;
	}
}

//  Include the functions
include_once CORE_BASE . 'functions.php';

//  Our core classes to load
$classes = array(
	'config', 'file', 'error', 'storage', 
	'request', 'validator', 'crypt', 'database', 'response', 'input', 'url', 
	'routes', 'email', 'helper'
);

$dependants = array(
	'ajax', 'cache', 'session', 'image', 'csrf', 'template'
);

//  Just load our class and we'll do the rest
$scaffoldPath = CORE_BASE . 'classes/scaffold.php';

//  Load Scaffold
if(file_exists($scaffoldPath)) {
	include_once $scaffoldPath;
	$scaffold = new Scaffold($config, $classes, $dependants);
} else {
	$badFiles[] = $scaffoldPath;
	die('Scaffold class not loaded. Sky is falling.');
}

//  When any errors get thrown, call our error class
set_exception_handler(array('Error', 'exception'));
set_error_handler(array('Error', 'native'));
register_shutdown_function(array('Error', 'shutdown'));