<?php defined('IN_APP') or die('Get out of here');

/**
 *    Scaffold v0.1
 *    by the Codin' Co.
 *
 *    Here's some handy functions we think you'll like.
 */
 
//  Include a file (optionally, with data)
//  grab('file.php', array('testVar' => 'hello, I am $testVar'));
function grab($what, $data = array()) {
    global $badFiles;
    
    if(file_exists($what)) {
        //  Include the $data array
        if(is_array($data) and !empty($data)) extract($data);
        
        //  Don't actually output anything
        ob_start();
        
        //  Grab the file
        include_once $what;
        
        //  Give back the output buffer as a string
        return ob_get_clean();
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

function load_time() {
    return round(microtime(true) - TIMER_START, 4);
}