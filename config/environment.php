<?php defined('IN_APP') or die('Get out of here');

/**
 *    Scaffold v0.1
 *    by the Codin' Co.
 *
 *    Your site's environment (local, live, etc.) settings.
 */
 
$config['env'] = array(
    //  Choose from "live" or "local" 
    //  Live will turn off debugging and error displaying, local will do the opposite
    'mode' => 'local'
);


//  You can override a mode's settings here
//  by commenting any of the following lines out

//  Log any errors
//$config['env']['log'] = true; // TODO

//  Display any errors to the screen
//$config['env']['debug'] = true;

//  Set the error_reporting() level
//$config['env']['error_level'] = E_ALL & ~E_NOTICE;