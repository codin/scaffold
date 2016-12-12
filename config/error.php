<?php defined('IN_APP') or die('Get out of here');

/**
 *	Scaffold v0.1.1
 *	by the Codin' Co.
 *
 *	Configure error levels in more detail
 */

//  To enable/disable the viewing of errors, see config/environment.php
$config['error'] = array(
	
	//  What levels do you want to handle with the error class?
	'levels' => array(
		//  Notice-level errors
		//  Your site won't break if you have these errors.
		//  Caused by undefined variables, accessing array indexes that don't exist, etc.
		E_USER_NOTICE,
		
		//  Warning-level errors
		//  Errors that are serious, but don't need to stop PHP running.
		//  Caused by faulty DB connections, setting
		E_USER_WARNING,
		
		//  These are the worst kind of error.
		//  User-thrown errors, syntax errors. PHP dies when these eixst.
		E_USER_ERROR
	),
	
	//  Display any errors on the screen
	//  This overwrites the environment settings, uncomment for a manual override
	//  'display' => true
	
	//  Log errors to file? This does not affect outputted errors
	'logging' => true
);