<?php !defined('IN_APP') and header('location: /');

//  Scaffold v0.1 CLI
//  SUPERBETA

error_reporting(0);

//  Load our methods
if(isset($argv[1])) {
    $methods = include_once 'methods.php';

    //  Handle all the requests here
    if(isset($methods[$argv[1]])) {
        $method = $methods[$argv[1]];
        
        if(is_callable($method)) {
            $method(isset($argv[2]) ? $argv[2] : null);
        } else {
            echo $method;
        }
    }
}

//  Stupid CLI
echo "\n";