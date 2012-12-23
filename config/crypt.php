<?php defined('IN_APP') or die('Get out of here');

/**
 *	Scaffold v0.1.1
 *	by the Codin' Co.
 *
 *	Encrypt or encode strings of text
 */
 
// Set the encoding method.
$config['crypt'] = array(
	
	//  Encyrption method
	'encrypt_method' => 'sha512', //  allowed: sha1, sha256, sha512, MD5, DES, Whirlpool
	
	//  Method of encoding 
	'encode_method' => 'base64', //  allowed: rot13, base64
	
	//  A unique salt to increase your encrypted text's security
	//  
	'salt' => '872yb78y8hn8gn8hn9a23enhd3he89hnd3eh3'
);