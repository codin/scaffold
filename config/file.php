<?php defined('IN_APP') or die('Get out of here');

/**
 *	Scaffold v0.1.1
 *	by the Codin' Co.
 *
 *	Coming soon.
 */
 
// Set the encoding method.
$config['file'] = array(
	
	// Encyrption method
	'default_store' => APP_BASE . 'files/',
	
	// max upload size
	'max_upload' => 20000000,
	
	// allowed extensions
	'allowed_types' => array(
		'jpg',
		'jpeg',
		'png',
		'gif',
		'html',
		'txt'
	)
);