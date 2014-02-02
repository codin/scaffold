<?php !defined('IN_APP') and header('location: /');

class Template {
	private static $_routes;
	public static $vars = array();
	public static $templatepath = TEMPLATE_PATH;

	public function __construct() {
		//  Set some default variables to use in the template
		$this->set(array(
			'load_time' => load_time(),
			'base' => Url::base(),
			
			'scaffold_version' => scaffold_version()
		));
	}
	
	public static function init($scaffold) { 
		self::$_routes = $scaffold->objects['routes'];
	}

	public function render($what = '', $echo = true) {
		//  Set the view to load
		if(empty($what)) {
			$what = self::$_routes->parse();
		}
		
		//  Looad the view
		$this->loadView($what);
		
		//  And load the main template
		$template = grab(self::$templatepath, self::$vars);
		$template = $this->parse($template);
				
		if($echo !== false) {
			echo $template;
		}
				
		return $template;
	}
	
	public function loadView($what = '') {
		if(!isset(self::$vars['view'])) {
			if(file_exists(APP_BASE . 'views/' . $what . '.php')) {
				self::$vars['view'] = grab(APP_BASE . 'views/' . $what . '.php', self::$vars);
			} else {
				//  Set a 404
				Response::set(404);
				
				//  If it doesn't exist, show the error view
				self::$vars['view'] = grab(APP_BASE . 'views/' . Config::get('404_page') . '.php', self::$vars);
			}
		}
		
		return self::$vars['view'];
	}
	
	public function parse($template) {
		$vars = self::$vars;
		$vars['_alnum'] = 'a-zA-Z0-9_';
		
		//  Replace {{variables}}
		$template = preg_replace_callback('/{{([' . $vars['_alnum'] . ']+)(\/[' . $vars['_alnum'] . ' \.,+\-\/!\?]+)?}}/', function($matches) use($vars) {
			if(count($matches) === 3) {
				$matches[1] = $matches[1] . '/' . $matches[2];
				unset($matches[2]);
			}
		
			//  Discard the first match, and check for fallbacks
			$matches = explode('/', last($matches));
			
			//  There will always be a first key
			$match = first($matches);
			
			//  Set the fallback value, if it exists
			$fallback = isset($matches[1]) ? $matches[1] : '';
			
			//  Return matching variables, if they exist
			//  AND are not null or empty-ish
			if(isset($vars[$match])) {
				return $vars[$match];
			}
			
			//  Try a fallback
			return $fallback;
		}, $template);
		
		//  [conditionals][/conditionals]
		$template = preg_replace_callback('/(\[[\!?' . $vars['_alnum'] . ']+\])(.*?\[\/[' . $vars['_alnum'] . ']+\])/s', function($matches) use($vars) {
			$match = str_replace(array('[', ']'), '', $matches[1]);
			
			$cond = isset($vars[$match]) and !empty($vars[$match]);
			
			//  [!inverse][/inverse]
			if(strpos($match, '!') !== false) {
				$match = str_replace('!', '', $match);
				$cond = !isset($vars[$match]) or empty($vars[$match]);
			}
			
			if($cond !== false) {
				return trim(preg_replace('/\[[\/!]?' . $match . '\]/', '', $matches[0]));
			}
			 
			return '';
		}, $template);
		
		//  Include partials (~partial~)
		$template = preg_replace_callback('/~([' . $vars['_alnum'] . ']+)~/', function($matches) use($vars) {
			return grab(APP_BASE . 'partials/' . preg_replace('/[^' . $vars['_alnum'] . ']+/', '', $matches[0]) . '.php', $vars);
		}, $template);
		
		return $template;
	}
	
	public function set($key, $val = '') {
		if(is_array($key)) {
			foreach($key as $k => $v) {
				$this->set($k, $v);
			}
			
			return $this;
		}
		
		if($key === 'path') {
			return $this->setPath($val);
		}
		
		self::$vars[$key] = $val;
		
		return $this;
	}
	
	public function setPath($path) {
		if(file_exists($path)) {
			return self::$templatepath = $path;
		}
		
		Error::log('Path ' . $path . ' not found');
	}
	
	public function get($key, $fallback = '') {
		if(isset(self::$vars[$key])) {
			return self::$vars[$key];
		}
		
		return $fallback;
	}
}