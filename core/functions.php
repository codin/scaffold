<?php defined('IN_APP') or die('Get out of here');

/**
 *	Scaffold v0.1
 *	by the Codin' Co.
 *
 *	Here's some handy functions we think you'll like.
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
		var_dump($what);
	echo '</pre>';
}

//  Load time
//  Returns the duration of time taken to compile the app until the function was called
function load_time() {
	return round(microtime(true) - TIMER_START, 4);
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

//  Some neat little Scaffold internal functions
function scaffold_version() {
	return SCAFFOLD_VERSION;
}

//  Reliably get an IP address
function ip_address() {
	$s = $_SERVER;
	$methods = array('http_client_ip', 'http_pragma', 'http_x_forwarded_for', 'http_forwarded', 'remote_addr');
	
	foreach($methods as $method) {
		$method = strtoupper($method);
		if(isset($s[$method]) and !empty($s[$method])) {
			//  Be 100% aure we're returning an IP
			return preg_replace('/[^0-9\.:]+/', '', 'test' .$s[$method]);
		}
	}
	
	return '127.0.0.1';
}

//  Get a random string of optional length
function random_string($length = 10, $range = 'abcdefghijklmnopqrstuvxwxyz1234567890') {
	$return = array();
	$strlen = strlen($range);
	
	for($i = 0; $i < $length; $i++) {
		$output = $range[rand(0, $strlen - 1)];
		if($i > 1 and $return[$i - 1] === $output) {
			$output = $range[rand(0, $strlen - 1)];
		}
		
		$return[$i] = $output;
	}
	
	return join('', $return);
}

//  Using HTTPS?
function is_https() {
	return $_SERVER['HTTPS'] === 'on';
}

//  Auto-link any URLs
function linkify($url) {
	$url = preg_replace('/(https?:\/\/\S+)/', '<a href="\1" title="\1">\1</a>', $url);
	$url = preg_replace('/(^|\s)@(\w+)/', '<a class="twitter-link" href="http://twitter.com/\2"><span>@</span>\2</a>', $url);
	$url = preg_replace('/(^|\s)#(\w+)/', '\1<a class="hashtag-link" href="http://search.twitter.com/search?q=%23\2">#\2</a>', $url);
	
	return $url;
}