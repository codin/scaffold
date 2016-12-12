<?php !defined('IN_APP') and header('location: /');


/**
 * A class to cache static pages and files that have been
 * included or uploaded from external sources.
 */
class Cache {

	/**
	 * @desc Create a new cache file
	 * @param name, the name of the file
	 * @param data, and array of data to cache
	 * @return whether or not the file was created
	 */
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

	/**
	 * @desc Get a cache file
	 * @param name, the name of the file
	 * @return the content of the cache, else false
	 */
	public static function get($name) {
		if(File::exists(TEMP_BASE . 'cache/' . $name)) {
			$file = File::get($name, 120321, TEMP_BASE . 'cache/');
			$decoded = json_decode($file->content);
			return $decoded->content;
		}

		return false;
	}

	/**
	 * DEPRECATED DUE TO MIS-NAMING, USE Cache::delete(...)
	 */
	public static function clear($name) {
		trigger_error("Cache::clear() is DEPRECATED, please use Cache::delete() instead!", E_USER_NOTICE);
	}

	/**
	 * @desc delete a cache file
	 * @param the name of the file 
	 */
	public static function delete($name) {
		$path = TEMP_BASE . 'cache/';

		if($path != null && File::exists($path . $name)) {
			File::delete($name, $path);
		}
	}
}