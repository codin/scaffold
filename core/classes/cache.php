<?php !defined('IN_APP') and header('location: /');


/**
 * A class to cache static pages and files that have been
 * included or uploaded from external sources.
 */
class Cache {

	public static function create($name, $data) {
		if(is_array($data)) {
			$data['modified'] = time();
			File::write($name, json_encode($data), false, TEMP_BASE . 'cache/');
			return true;
		} 

		Error::create(
			'The second parameter must be an array. 
			With keys : name, content and profile'
		);

		return false;
	}

	public static function get($name) {
		if(File::exists(TEMP_BASE . 'cache/' . $name)) {
			$file = File::get($name, 120321, TEMP_BASE . 'cache/');
			$decoded = json_decode($file->content);
			return $decoded->content;
		}

		return false;
	}

	public static function clear($name) {
		$path = TEMP_BASE . 'cache/';

		if($path != null && File::exists($path . $name)) {
			File::delete($name, $path);
		}
	}
}

/** 
 * If enabled cache a view to a file, and load that if there is no new content to be displayed.
 * Use template class to display it.
 */