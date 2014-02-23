<?php

namespace Scaffold\Routes;

/**
 *	 The Router class handles what needs to be loaded and where we pass data to
 *
 *   @author	Codin' Co. <hi@codin.co>
 *   @version	2.0.0-alpha
 *   @package	Scaffold\Routes
 *
 */

public class Router {

	/**
	 *	 Extracts information from a route 'rule', 
	 *	 @param $rule - A rule for the route e.g. "/index:public->index"
	 *					See rule guide for mor information.
	 *	 @return $extracted - An array of extracted information
	 */
	public static function extract($rule) {
		
		// The rule isn't a string so we'll return false
		if(!is_string($rule)) {
			return false;
		}

		/**
		 * Break the rule into pieces
		 */

		// Seperate url and route
		// delimited by :
		$pieces = explode(':', $rule);
		$url = $pieces[0];
		$route = $pieces[1];

		// Seperate class and method from route
		$route_pieces = explode('->', $route);
		$class = $route_pieces[0];
		$method = $route_pieces[1];

		// Set up return values
		$extrctd = array(
			'url' => $url,
			'class' => $class,
			'method' => $method
		);

		/**
		 *	Validate values
		 */
		
		// No url was specified, assume index was intended
		if(!$url or $url == '') {
			$url = '/index';
		}

		// We need a class and method, otherwise return just url and boolean class and methods
		if(!$class or !$method) {
			$extrctd['class'] = !!$class;
			$extrctd['method'] = !!$method;
		}

		// Return an understandable extract of this rule
		return $extrctd;
	}
}