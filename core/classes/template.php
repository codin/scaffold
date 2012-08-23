<?php !defined('IN_APP') and header('location: /');

class Template {

    private $_routes;
    public static $vars = array();

    public function __construct() {
        $this->_routes = new Routes;
    }

    public function render($what = '') {
        //  Set the view to load
        if(empty($what)) {
            $what = $this->_routes->parse();
        }
        
        //  Set the view variable
        if(file_exists(APP_BASE . 'views/' . $what . '.php')) {
            self::$vars['view'] = grab(APP_BASE . 'views/' . $what . '.php');
        } else {
            //  If it doesn't exist, show the error view
            self::$vars['view'] = Config::get('404_page');
        }
        
        //  And load the main template
        $template = grab(TEMPLATE_PATH);
                
        return $this->parse($template);
    }
    
    public function parse($template) {
        //  Parse the template
        $template = preg_replace_callback('/{{(.*)}}/', function($matches) {
            //  Load all the available template variables
            $vars = load_vars();
            
            if(isset($matches[1]) and isset($vars[$matches[1]])) {
                return $vars[$matches[1]];
            }
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
    
    public static function vars() {
        return self::$vars;
    }
}

function load_vars() {
    $template = new Template;
    return $template->vars();
}