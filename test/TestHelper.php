<?php

/**
 *    Prepares the framework for PHPUnit
 */

//  Define the base to the root of the framework
define('BASE', dirname(__FILE__) . '/../');

//  Allow us to load files during testing
define('IN_APP', true);

//  Load the paths required for "config/bootstrapper.php"
require_once BASE . 'config/paths.php';

//  Initialize the framework
require_once CORE_BASE . 'bootstrapper.php';