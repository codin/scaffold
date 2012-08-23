<?php defined('IN_APP') or die('Get out of here');

/**
 *    Scaffold v0.1
 *    by the Codin' Co.
 *
 *    Here lies the basic bootstrapper, which instantiates all the classes and loads
 *    all of the files up properly. Here goes!
 */

//  Strip magic quotes
if(get_magic_quotes_gpc()) {
    foreach(array($_GET, $_POST, $_COOKIE, $_REQUEST) as $m) {
        $m = json_decode(stripslashes(json_encode($m, JSON_HEX_APOS)), true);
    }
}

//  Set the default timezone to London if you don't have any set
if(!ini_get('date.timezone')) {
    date_default_timezone_set('Europe/London');
}
 
//  Load the rest of the config
$config = array();
$files = array('environment', 'language', 'routes', 'database', 'misc');

//  Try loading the config files
//  If they don't work, log to an array for now

//  Get our badFiles array ready
$badFiles = array();

//  Loop all the config files to check they're good
foreach($files as $file) {
    $filename = BASE . 'config/' . $file . '.php';
    
    if(file_exists($filename)) {
        include $filename;
    } else {
        $badFiles[] = $filename;
    }
}

//  Include the functions
include_once CORE_BASE . 'functions.php';

//  Load our core classes
$classes = array('config', 'error', 'response', 'ajax', 'file', 'input', 'url', 'routes', 'template', 'helper');
load_classes(array('scaffold'), load_classes($classes, $config, false));

//  When any errors get thrown, call our error class
//set_exception_handler(array('Error', 'exception'));
//set_error_handler(array('Error', 'native'));
//register_shutdown_function(array('Error', 'shutdown'));