<?php defined('IN_APP') or die('Get out of here');

/**
 *    Scaffold v0.1
 *    by the Codin' Co.
 *
 *    Here's some handy functions we think you'll like.
 */
 
//  Get the contents of a file as a string (optionally, with data)
//  grab('file.php', array('testVar' => 'hello, I am $testVar'));
function grab($what, $data = array()) {
    ob_start();
    fetch($what, $data);
    return ob_get_clean();
}

function fetch($what, $data = array()) {
    global $badFiles;
    
    if(file_exists($what)) {
        //  Include the $data array
        if(is_array($data) and !empty($data)) extract($data);
        
        //  Grab the file
        include_once $what;
    } else {
        $badFiles[] = $what;
    }
    
    return false;
}

//  Debug a variable
//  dump($_SERVER);
function dump($what) {
    echo '<pre>';
        print_r($what);
    echo '</pre>';
}

//  Load time
//  Returns the duration of time taken to compile the app until the function was called
function load_time() {
    return round(microtime(true) - TIMER_START, 4);
}

//  Load core classes with optional config
//  Not really a public function
function load_classes($array, $config, $instantiate = true) {
    //  If it's not an array of classes, bail out
    if(!is_array($array) or empty($array)) {
        return false;
    }
    
    $classes = array();
    
    foreach($array as $class) {
        
        //  And grab the file
        fetch(CORE_BASE . 'classes/' . $class . '.php', $config);
        
        //  If we need to call the class, might as well do that
        if($instantiate === true) {
            $u = ucfirst($class);
            
            if(class_exists($u)) {
                
                //  For static classes
                if(method_exists($u, 'init')) {
                    $classes[$class] = $u;
                    call_user_func($u . '::init', $config);
                } else {
                    $classes[$class] = new $u($config);                
                }
            }
        } else {
            $classes[] = $class;
        }
    }
    
    return $classes;
}

//  Return the first element in an array
function first($array) {
    if(is_array($array) and !empty($array)) {
        //  We can't just return $array[0], because they might have unset() it.
        foreach($array as $val) {
            return $val;
        }
    }

    return false;
}

//  Opposite of first(). Literally.
function last($array) {
    if(is_array($array)) {
        return first(array_reverse($array));
    }
    
    return false;
}

//  150 => "150th", 3 => "3rd"
function numeral($number) {
	$test = abs($number) % 10;
	$ext = ((abs($number) % 100 < 21 and abs($number) % 100 > 4) ? 'th' : (($test < 4) ? ($test < 3) ? ($test < 2) ? ($test < 1) ? 'th' : 'st' : 'nd' : 'rd' : 'th'));
	return $number . $ext; 
}

//  Return a word count
//  Character count is strlen()
function count_words($str) {
	return count(preg_split('/\s+/', strip_tags($str), null, PREG_SPLIT_NO_EMPTY));
}

//  Pluralise a string based on a number
//  pluralise(24, 'cat') => cats, pluralise(3, 'bench', 'es') => benches
function pluralise($amount, $str, $alt = '') {
	return intval($amount) === 1 ? $str : $str . ($alt !== '' ? $alt : 's');
}

//  Get the relative time from a epoch timestamp
function relative_time($date) {
	$elapsed = time() - strtotime($date);
	
	if($elapsed <= 1) {
		return 'Just now';
	}
	
	$times = array(
		31104000 => 'year',
		2592000 => 'month',
		604800 => 'week',
		86400 => 'day',
		3600 => 'hour',
		60 => 'minute',
		1 => 'second'
	);
	
	foreach($times as $seconds => $title) {
		$rounded = $elapsed / $seconds;
		
		if($rounded > 1) {
			$rounded = round($rounded);
			return $rounded . ' ' . pluralise($rounded, $title) . ' ago';
		}
	}
}