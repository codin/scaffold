<?php !defined('IN_APP') and header('location: /');


/**
 * A class to cache static pages and files that have been
 * included or uploaded from external sources.
 */
class Cache {

	public function create($name, $data) {
		if(is_array($data)) {
			$data['modified'] = time();
			File::write($name, json_encode($data), false, APP_BASE . 'cache/');
			return true;
		} 

		Error::create(
			'The second parameter must be an array. 
			With keys : name, content and profile'
		);

		return false;
	}

	public function get($name) {
		if(File::exists(APP_BASE . 'cache/' . $name)) {
			$file = File::get($name, null, APP_BASE . 'cache/');
			$decoded = json_decode($file['data']);
			return $decoded['content'];
		}

		return false;
	}
}

/** 
 * If enabled cache a view to a file, and load that if there is no new content to be displayed.
 * Use template class to display it.
 */