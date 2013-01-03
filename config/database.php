<?php defined('IN_APP') or die('Get out of here');

/**
 *	Scaffold v0.1.1
 *	by the Codin' Co.
 *
 *	You will need a database type supported by PDO (e.g MySQL).
 */
 
$config['database'] = array(
	//  Your database host. Usually 127.0.v0.1.1 or localhost
	'host' => '127.0.0.1',
	
	//  The database user that has permissions to read/write/execute on the database.
	'user' => 'root',
	
	//  And the corresponding password
	'pass' => '',
	
	//  The name of the database in question
	'name' => 'scaffold',
	
	//  And the port (usually 3306)
	'port' => 3306,
	
	//  Database driver (defaults to MySQL)
	//  Since Scaffold uses PDO, you can choose from any of these:
	//  http://php.net/manual/en/pdo.drivers.php
	'driver' => 'mysql'
);