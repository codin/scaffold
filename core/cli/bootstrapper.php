<?php !defined('IN_APP') and header('location: /');

/**
 *  Scaffold CLI v0.1
 */
 
//  We make the errors, not PHP
//error_reporting(0);

//  Include the command-line base
require_once 'command.php';

//  Set up the Command Center
$cmd = new Command($argv);
$cmd->run();

//  And we're done!
echo PHP_EOL;