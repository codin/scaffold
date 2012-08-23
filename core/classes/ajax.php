<?php !defined('IN_APP') and header('location: /');

class Ajax {
    public static $noDirect = false;
    
    //  Ajax::output(array('variable' => 'output'));
    //  => {"variable":"output"}
	public static function output($data, $allowCallbacks = true) {
	
	    //  Check it's being called with AJAX
	    //  But only if we tell it to
	    if(!self::validOrigin()) {
	        Error::log('Invalid origin');
	        exit;
	    }
	
	    //  I do love a bit of json
	    Response::set('json');
	    
	    //  Store our encoded data as a variable
	    $json = json_encode($data);
	    
	    //  Just make sure 
	    if(!$json) {
	        return;
	    }
	        
        //  Do we allow ?callback=test parameters?
        if($allowCallbacks === true) {
            $callback = preg_replace('/[^0-9a-z\-_\d]/i', '', Input::get('callback'));
            
            if($callback) {
                $json = $callback . '(' . $json  . ');';
            }
        }
        
        //  Give 'em what they wanted
        echo $json;
	}
	
	public static function validOrigin() {
	    //  If we allow direct, it doesn't matter
	    if(self::$noDirect === false) {
	        return true;
	    }
	    
	    return $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
	}
}