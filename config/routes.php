<?php defined('IN_APP') or die('Get out of here');

/**
 *	Scaffold v0.1.1
 *	by the Codin' Co.
 *
 *	This file is vital for your app. It contains all of the site's routes,
 *	and your site will not work without it.
 *
 *	There are two required routes:
 *	 - index: this is the app's index page and fallback controller, although
 *			  it'll fall back to an the error route instead.
 *	 - error: this is the controller that gets called when any app-specific
 *			  or PHP-level error is made.
 *
 *	Any other route is valid. As well as using static strings:
 *	 $config['routes']['about'] => 'about'
 *
 *	You can also use inline "selectors", which begin with a bracketed colon "(:" and end with a bracket ")":
 *	 - (:any), which will match any valid character (a-z, A-Z, 0-9, and these characters: . - _ ~ % : _ \)
 *	 - (:num), which will match a numeric character (0-9 and a dot).
 *	 - (:alpha), which will match any alpha-numeric characters (a-z and A-Z)
 */
 
//  URL regex => controller/view/model to use.
$config['routes'] = array(
	//  Our error controller
	//  This not only handles 404s/403s, but also system errors.
	'error' => 'error',
	
	//  These two routes are required
	//  You can change them, but don't delete them!
	
	//  The main index controller
	'index' => 'main',
	'index/help' => 'main.help'
);