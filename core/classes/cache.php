<?php !defined('IN_APP') and header('location: /');


/**
 * A class to cache static pages and files that have been
 * included or uploaded from external sources.
 */
class Cache {

	public static function create($name, $data) {
		$path = TMP_PATH . 'cache/';

		if($data) {
			$data2['data'] = $data;
			$data2['modified'] = time();
			return File::write($name, json_encode($data2), false, $path);
		} 

		return false;		
	}

	public static function get($name) {
		$path = TMP_PATH . 'cache/';
		$file = File::get($name, 99999999, $path);
		return json_decode($file->content)->data;
	}

	public static function wipe($name) {
		$path = TMP_PATH . 'cache/';
		if(File::exists($path . $name)) {
			return File::remove($name, $path);
		}

		return false;
	}
}