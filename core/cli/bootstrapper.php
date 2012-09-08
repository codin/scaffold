<?php !defined('IN_APP') and header('location: /');

//  Scaffold v0.1 CLI
//  SUPERBETA

error_reporting(0);

include_once 'cli.php';

// put some spacing before
echo "\n";

//  Load our methods
if(isset($argv[1])) {
    $methods = include_once 'methods.php';
   	
    // create a new Cli object
    $cli = new Cli($argv, $methods);
    
    // parse the inputs
    $cli->parse();
}

//  Stupid CLI
echo "\n" . "\n";