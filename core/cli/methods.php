<?php

return array(
    'install' => function($arg) {
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
    
    //  Alias these two
    'version' => SCAFFOLD_VERSION,
    '-v' => SCAFFOLD_VERSION,
    
    'update' => function() {}
);