<?php !defined('IN_APP') and header('location: /');

class Routes {
	private $routes = array();
	private $url = false;
	private $match;
	
	public function __construct() {
		//  Set our routes up
		$this->routes = Config::get('routes');
		
		//  Store the current URL
		$this->url = Url::request();
		
		//  Set a fallback
		if(!$this->url) {
			$this->url = Config::get('default_method');
		}
	}
	
	public function parse($force = '') {
		if(!$this->match) {
			$this->match = $this->_build();
		}
		
		return $this->match;
	}
	 
	private function _build() {   
		$search = array(':any', ':num', ':alpha');
		$replace = array('[0-9a-zA-Z~%\.:_\\-]+', '[0-9]+', '[a-zA-Z]+');
		
		$this->error = Config::get('routes.error');
		Config::set('routes.error', '');
		
		//  Loop through our routes
		foreach(array_reverse($this->routes) as $route => $controller) {
			$route = str_replace($search, $replace, $route);
			
			//  Match the route against the URL 
			preg_match('#^' . $route . '$#', $this->url, $matches);
			
			if(isset($matches[0])) {
				//  Basic URL redirection
				if(strpos($controller, '://') !== false) {
					return Response::redirect($controller);
				}
				
				//  Handle methods
				if(strpos($controller, '.') !== false) {
					$controller = explode('.', $controller);
					$controller = array($controller[0], $controller[1]);
				} else {
					$controller = array($controller);
				}

				return $controller;
			}
		}
		
		return array($this->error, Config::get('404_page'));
	}
}