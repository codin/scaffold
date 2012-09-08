<?php

$methods = array(
    //  Install a helper
    'install' => function($arg) {
    
        if(!$arg) {
            echo 'Wait, what did you want me to install?';
            return;
        }
    
        // $endpoint = 'http://helpers.scaffold.im';
        $endpoint = 'http://localhost:8000/' . $arg;
        $json = json_decode(file_get_contents($endpoint . '/about.json'));
        
        if(!$json) {
            echo 'Helper "' . $arg . '" does not exist.';
            return;
        }
        
        //  Let the user know
        echo 'Fetching ' . $json->name . '...';
        
        //  Actually get the file
        $contents = file_get_contents($endpoint . '/' . $json->file);
        
        //  Write contents
        if(file_put_contents(APP_BASE . 'helpers/' . $json->file, $contents)) {
            echo 'Done. Installed ' . $json->name . ', version ' . $json->version . '!';
        } else {
            echo 'Could not install.';
        }
    },
    
    //  Uninstall/remove a helper
    'uninstall' => function($arg) {
    	$path = APP_BASE . 'helpers/' . $arg . '.php';
    	
    	// if its a file
    	if(is_file($path) and file_exists($path) and unlink($path)) {
    		echo '1 helper has been uninstalled successfully.';
    	} else {
    		echo 'Unable to remove helper: "' . $arg . '"';
    	}
    },
    
    //  Give the current Scaffold version
    'version' => SCAFFOLD_VERSION,
    
    //  Update to the latest version
    'update' => function() {},
    
    //  What's the date?
    'now' => function() {
        echo time();
    },
    
    'url' => function() {
        `echo 'test' | pbcopy`
    }
);


function list_methods() {
    global $methods;
    return $methods;
}

//  List methods
$methods['help'] = $methods['list'] = function() {
    echo 'You can currently call any of these methods:

';
    foreach(list_methods() as $key => $val) {
        echo $key . "\n";
    }
};