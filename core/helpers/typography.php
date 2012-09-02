<?php !defined('IN_APP') and header('location: /');

class Typography {
    //  Run through all the filters 'n' stuff
    public static function enhance($str) {
        //  TODO: make it not run in these tags
        $tags = 'code|pre|kbd|samp|tt|style|script';
        
        $str = self::smartQuote($str);
        $str = self::smartDash($str);
        $str = self::autoEllipsis($str);
        
        return $str;
    }
    
    //  Give our dashes a nice old smart touch
    public static function smartDash($str) {
        $search = array('---', '--');
        $replace = array('&mdash;', '&ndash;');
        
        return str_replace($search, $replace, $str);
    }
    
    //  Add some smart quotes
    public static function smartQuote($str) {
        //  Opening and closing character matches
        $range = 'a-zA-Z0-9';
        $closing = '([' . $range . '])';
        $opening = '([^' . $range . '])';
        
        //  Handle weird instances
        $str = str_replace("''", '&lsquo;&rsquo;', $str);
        $str = str_replace('""', '&ldquo;&rdquo;', $str);
        
        //  And everything else
        foreach(array('\'' => 's', '"' => 'd') as $quote => $i) {
            $str = preg_replace('/' . $opening . '(' . $quote . ')/', '$1&l' . $i . 'quo;', $str);
            $str = preg_replace('/' . $closing . '(' . $quote . ')/', '$1&r' . $i . 'quo;', $str);
        }
            
        return $str;
    }
    
    //  Make our dots proper like
    public static function autoEllipsis($str) {
        return str_replace('...', '&hellip;', $str);
    }
}