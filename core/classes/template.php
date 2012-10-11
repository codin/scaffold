<?php !defined('IN_APP') and header('location: /');

class Template {

    private static $_routes;
    public static $vars = array();

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

    public function render($what = '') {
        //  Set the view to load
        if(empty($what)) {
            $what = self::$_routes->parse();
        }
        
        //  Set the view variable
        if(file_exists(APP_BASE . 'views/' . $what . '.php')) {
            self::$vars['view'] = grab(APP_BASE . 'views/' . $what . '.php', self::$vars);
        } else {
            //  Set a 404
            Response::set(404);
            
            //  If it doesn't exist, show the error view
            self::$vars['view'] = grab(APP_BASE . 'views/' . Config::get('404_page') . '.php', self::$vars);
        }
        
        //  And load the main template
        $template = grab(TEMPLATE_PATH, self::$vars);
                
        return $this->parse($template);
    }
    
    public function parse($template) {
        $alnum = 'a-zA-Z0-9_';
        $vars = self::$vars;
        
        //  Replace {{variables}}
        $template = preg_replace_callback('/{{([' . $alnum . ']+)(\/[' . $alnum . ' \.,+\-\/!\?]+)?}}/', function($matches) use($vars) {
            //  Discard the first match, and check for fallbacks
            $matches = explode('/', last($matches));
            
            //  There will always be a first key
            $match = first($matches);
            
            //  Set the fallback value, if it exists
            $fallback = isset($matches[1]) ? $matches[1] : '';
            
            //  Return matching variables, if they exist
            //  AND are not null or empty-ish
            if(isset($vars[$match]) and $vars[$match]) {
                return $vars[$match];
            }
            
            //  Try a fallback
            return $fallback;
        }, $template);
        
        //  [conditionals][/conditionals]
        $template = preg_replace_callback('/(\[[\!?' . $alnum . '\= \/]+\])(.*?\[\/[' . $alnum . ']+\])/s', function($matches) use($vars) {
            $match = str_replace(array('[', ']'), '', $matches[1]);
            
            //  Handle equality
            if(strpos($match, '=') !== false) {
                $match = explode('=', $match);
                
                foreach($match as $i => $m) {
                    $match[$i] = trim($m);
                }
                
                $cond = isset($vars[$match[0]]) and $vars[$match[0]] == $match[1];
                
                $match = $matches[0] = preg_replace('/=.*/', '', $match[0]);
            }
            
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
        $template = preg_replace_callback('/~([' . $alnum . ']+)~/', function($matches) use($alnum) {
            return grab(APP_BASE . 'partials/' . preg_replace('/[^' . $alnum . ']+/', '', $matches[0]) . '.php');
        }, $template);
        
        return $template;
    }
    
    public function set($key, $val = '') {
        if(is_array($key)) {
            foreach($key as $k => $v) {
                $this->set($k, $v);
            }
            
            return;
        }
        
        self::$vars[$key] = $val;
    }
    
    public function get($key, $fallback = '') {
        if(isset(self::$vars[$key])) {
            return self::$vars[$key];
        }
        
        return $fallback;
    }
}