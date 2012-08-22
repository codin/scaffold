<?php defined('IN_APP') or die('Get out of here');

/**
 *    Scaffold v0.1
 *    by the Codin' Co.
 *
 *    Here lies the basic bootstrapper, which instantiates all the classes and loads
 *    all of the files up properly. Here goes!
 */
 
//  Load the rest of the config
$config = array();
$files = array('environment', 'language', 'routes', 'database');

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
$classes = array('config', 'error', 'response', 'ajax', 'file', 'input', 'url', 'routes');
load_classes(array('scaffold'), array(
    'classArray' => $classes,
    'classes' => load_classes($classes, $config, false),
    
    'config' => $config
));