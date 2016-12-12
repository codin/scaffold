<?php defined('IN_APP') or die('Get out of here');

/**
 *	Scaffold v0.1.1
 *	by the Codin' Co.
 *
 *	Options for working with the Image class
 */
 
// Set the encoding method.
$config['image'] = array(
	//  Export quality level, takes a number from 0 to 100
	//  Works very similar to Photoshop's "Save for Web".
	//  Higher the number, higher the filesize and quality.
	'quality' => 90,
	
	//  Where would you like to store cached images?
	'cache' => PUBLIC_BASE . 'assets/cache/'
);