<?php defined('IN_APP') or die('Get out of here');

/**
 *	Scaffold v0.1.1
 *	by the Codin' Co.
 *
 *	Application email setup. This varies depending on what method you use.
 */
 
$config['email'] = array(
	//  Set the type of email you want to use
	//  "standard", "postmark", or "mandrill"
	//
	//  NOTE: "standard" is not recommended as it's unreliable.
	'type' => 'postmark',
	
	//  Where to send application emails from
	'from' => 'craig@codin.co',
	
	
	//  Email methods
	//  These settings will only be used if you activate the email type.
	
	//  See http://postmarkapp.com
	'postmark' => array(
		'apiKey' => '4b5c52f3-dc9c-41ba-807b-4b7164487ba8'
	),
	
	//  See http://mandrill.com
	'mandrill' => array(
		'apiKey' => 'testing123',
		'project' => 'project123'
	)
);