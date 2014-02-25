<?php 

/**
 *   Scaffold, a tiny PHP webapp framework.
 *
 *   @author	Codin' Co. <hi@codin.co>
 *   @version	2.0.0-alpha
 *   @package	Scaffold
 *
 *   Some default routes. You'll probably want to change these too.
 */

 
/**
 *   An index page. Right now it's just for welcoming you to
 *   Scaffold, but in future it'll be whatever you make it.
 */
$app->get('(:index)', function($page, $params) use($app) {
	return $app->view()->render('index');
});

/**
 *   This is the not_found route. It lets you assign custom 404
 *   pages, but right now it's just a default. 
 */
$app->not_found(function($page, $params) use($app) {
	return $app->view()->render(404);
});