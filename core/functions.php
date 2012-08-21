<?php defined('IN_APP') or die('Get out of here');

/**
 *    Scaffold v0.1
 *    by the Codin' Co.
 *
 *    Here's some handy functions we think you'll like.
 */
 
//  Get the contents of a file as a string (optionally, with data)
//  grab('file.php', array('testVar' => 'hello, I am $testVar'));
function grab($what, $data = array()) {
    ob_start();
    fetch($what, $data);
    return ob_get_clean();
}

function fetch($what, $data = array()) {
    global $badFiles;
    
    if(file_exists($what)) {
        //  Include the $data array
        if(is_array($data) and !empty($data)) extract($data);
        
        //  Grab the file
        include_once $what;
    } else {
        $badFiles[] = $what;
    }
    
    return false;
}

//  Debug a variable
//  dump($_SERVER);
function dump($what) {
    echo '<pre>';
        print_r($what);
    echo '</pre>';
}

//  Load time
//  Returns the duration of time taken to compile the app until the function was called
function load_time() {
    return round(microtime(true) - TIMER_START, 4);
}

//  Load classes
function load_classes($array, $config, $instantiate = true) {
    //  If it's not an array of classes, bail out
    if(!is_array($array) or empty($array)) {
        return false;
    }
    
    $classes = array();
    
    foreach($array as $class) {
        
        //  And grab the file
        fetch(CORE_BASE . 'classes/' . $class . '.php', $config);
        
        //  If we need to call the class, might as well do that
        if($instantiate === true) {
            $u = ucfirst($class);
            
            if(class_exists($u)) {
                
                //  For static classes
                if(method_exists($u, 'init')) {
                    $classes[$class] = $u;
                    call_user_func($u . '::init', $config);
                } else {
                    $classes[$class] = new $u($config);                
                }
            }
        }
    }
    
    return $classes;
}