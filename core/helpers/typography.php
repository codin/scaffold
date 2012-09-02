<?php !defined('IN_APP') and header('location: /');

class Typography {
    //  Dashes
    private static $dumbDashes = array('---', '--');
    private static $smartDashes = array('&mdash;', '&ndash;');
    
    //  Ellipses
    private static $dumbEllipses = array('...', '***');
    private static $smartEllipses = array('&hellip;', '&#8943;');
    
    //  Ignore tags
    private static $ignoreTags = 'code|pre|kbd|samp|tt|style|script';

    //  Run through all the filters 'n' stuff
    public static function enhance($str) {
        $str = self::smartQuote($str);
        $str = self::smartDash($str);
        $str = self::autoEllipsis($str);
        
        //  Undo anything within code tags
        $str = preg_replace_callback('/<(' . self::$ignoreTags. ')>(.*)<\/(' . self::$ignoreTags . ')>/', function($matches) {
            return Typography::diminish($matches[0]);
        }, $str);
        
        return $str;
    }
    
    //  Give our dashes a nice old smart touch
    public static function smartDash($str) {
        return str_replace(self::$dumbDashes, self::$smartDashes, $str);
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
        return str_replace(self::$dumbEllipses, self::$smartEllipses, $str);
    }
    
    public static function diminish($str) {
        //  Quotes
        $smart = array('&lsquo;', '&rsquo;', '&ldquo;', '&rdquo;');
        $dumb = array('\'', '\'', '"', '"');
        
        return str_replace(
            array_merge($smart, self::$smartDashes, self::$smartEllipses),
            array_merge($dumb, self::$dumbDashes, self::$dumbEllipses),
        $str);
    }
}