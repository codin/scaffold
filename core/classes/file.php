<?php !defined('IN_APP') && header('location: /');

class File {
	
	/**
	 *	File::get('test.txt'); or File::get('test.txt', 10, 'path/to/file');
	 */
	static function get($name, $char_limit = false, $url = false) {
		
		// Sort our urls and paths out.
		if(!$url) $url = APP_BASE . 'files/';
		$path = $url . $name;
		
		// How many characters shall we read?
		if(!$char_limit) $char_limit = filesize($path);
		
		// If the file exists
		if(file_exists($path)) {
			$h = fopen($path, 'r');
			
			$stats = fstat($h);
			
			// Give us an array of info
			return array(
				'contents' => fread($h, $char_limit),
				'stats' => fstat($h),
				'name' => $name,
				'path' => $path
			);
		}
		
		// Otherwise return false
		return false;
	}
	
	static function delete() {
	
	}
	
	static function rename() {
		
	}
}