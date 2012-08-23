<?php !defined('IN_APP') && header('location: /');

class File {
	
	/**
	 *	@desc Get a file
	 *  @param Filename
	 *  @param Character Limit
	 *	@param Path/URL
	 *  @return Array 
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
	
	/**
	 *	@desc Delete a file
	 *  @param Filename
	 *  @param Path
	 *  @return Boolean 
	 */
	static function delete() {
		// TODO Make this function delete a file.
	}
	
	/**
	 *	@desc Rename a file
	 *  @param Filename
	 *  @param Path
	 *  @return Boolean 
	 */
	static function rename() {
		// TODO Make this function rename a file.
	}
	
	/**
	 *	@desc Edit a file
	 *  @param Filename
	 *  @param Path
	 *  @return String 
	 */
	static function edit() {
		// TODO Make this function edit contents of a text-based (e.g. no image or software specific file)
	}
	
	/**
	 *	@desc Upload a file
	 *  @param Temp Location
	 *  @param Destination
	 *  @return Boolean 
	 */
	static function upload() {
		// TODO Make this function upload a file to a folder from tmp
	}
	
	/**
	 *	@desc Move a file from temp location
	 *  @param Temp location
	 *  @param Destination
	 *  @return Boolean 
	 */
	private static function _move_from_tmp() {
		// TODO Move file from temp as part of upload
	}
}