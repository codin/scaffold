<?php

/**
 *	Scaffold v0.1.1
 *	by the Codin' Co.
 *
 *	If you're looking for database/application configuration, check out the "config" folder.
 *	If you want application code, check out the "app" folder.
 *	Otherwise, see http://scaffold.im for more details.
 */
 
if(version_compare(phpversion(), '5.3.2') < 0) {
	die("You're running an old version of PHP, which means you can't run Scaffold. Sorry about that!\n");
}

//  Set the base URL
//  You shouldn't need to change this, unless you change your file paths
//  If you need to change directory names, see config/paths.php
define('BASE', dirname(dirname($_SERVER['SCRIPT_FILENAME'])) . '/');

//  Set a constant to stop direct access
//  To check: defined('IN_APP') or die('Get out of here');
define('IN_APP', true);

//  Set the version of Scaffold
define('SCAFFOLD_VERSION', '0.1.1');

//  Start your clocks, mister!
define('TIMER_START', microtime(true));

//  Load our paths, since that's required for the bootstrapper
require BASE . 'config/paths.php';

//  Load the boostrapper
require CORE_BASE . 'bootstrapper.php';

//  Buh-bye!
exit;