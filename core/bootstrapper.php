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
$files = array('environment', 'language', 'routes', 'database', 'misc', 'crypt', 'session', 'file');

//  Try loading the config files
//  If they don't work, log to an array for now

//  Get our badFiles array ready
$badFiles = array();

//  Loop all the config files to check they're good
foreach($files as $file) {
    $filename = BASE . 'config/' . $file . '.php';
    
    if(file_exists($filename)) {
        $config[] = $file;
        include $filename;
    } else {
        $badFiles[] = $filename;
    }
}

//  Include the functions
include_once CORE_BASE . 'functions.php';

//  Load our core classes
$classes = array(
    //  No dependencies, vital for page load
    'config', 'error',
    
    //  Crypting stuff
    'crypt',
    
    //  Database class. Everything uses this. Apart from config and error.
    'database',
    
    // Session Class.
    'session',
    
    //  No depencies, optional classes
    //  May be depended on
    'response', 'ajax',
    
    //  Requires the config class
    //  May be depended on
    'file', 'image', 'input',
    
    //  Requires the URL and Input classes
    'url', 'routes', 'template',
    
    //  No dependencies, but helper classes may have dependencies
    //  on any/all of the above classes. We don't know.
    'helper'
);

//  Just load our class and we'll do the rest
$scaffoldPath = CORE_BASE . 'classes/scaffold.php';
$defaults = array();

//  Load Scaffold
if(file_exists($scaffoldPath)) {
    include_once $scaffoldPath;
    $scaffold = new Scaffold($config, $classes);
    
    //  Load the default controller/model
    foreach(array('controller', 'model') as $type) {
        include_once CORE_BASE . 'defaults/' . strtolower($type) . '.php';
        $defaults[$type] = new $type;
        
        if(method_exists($defaults[$type], 'init')) {
            call_user_func($defaults[$type] . '::init');
        }
    }
} else {
    $badFiles[] = $scaffoldPath;
    Error::log('Scaffold class not loaded. Sky is falling.');
    exit;
}

//  When any errors get thrown, call our error class
//set_exception_handler(array('Error', 'exception'));
//set_error_handler(array('Error', 'native'));
//register_shutdown_function(array('Error', 'shutdown'));
