<?php !defined('IN_APP') && header('location: /');

class File {
	
	/**
	 *	@desc Get a file
	 *  @param Filename
	 *  @param Character Limit
	 *	@param Path/URL
	 *  @return (object) Array 
	 */
	static function get($name, $char_limit = false, $url = false) {
		
		// Sort our urls and paths out.
		$path = self::_make_path($url, $name);
		
		// How many characters shall we read?
		if(!$char_limit) $char_limit = filesize($path);
		
		// If the file exists
		if(file_exists($path) && is_readable($path)) {
			// Open the file
			$h = fopen($path, 'r');
						
			// Give us an array of info
			$data = (object) array(
				'content' => fread($h, $char_limit),
				'stats' => fstat($h),
				'name' => $name,
				'path' => $path
			);
			
			// Close the stream
			fclose($h);
			
			return $data;
			
		}
		
		// Give an error.
		Error::log($path . ': Does not exist or is not readable.');
		
		// Otherwise return false
		return false;
	}
	
	/**
	 *	@desc Delete a file
	 *  @param Filename / Directory name
	 *  @param Path
	 *  @return Boolean 
	 */
	static function delete($name, $url = false) {
		$path = self::_make_path($url, $name);
		
		// if its a directory
		if(is_dir($path)) {
			return rmdir($path);
		}
		
		// if its a file
		if(is_file($path) && file_exists($path)) {
			return unlink($path);
		}
		
		return false;
	}
	
	/**
	 *	@desc Rename a file
	 *  @param Old name
	 *  @param New name
	 *  @param Url
	 *  @return Boolean 
	 */
	static function rename($name, $new, $url = false) {
		$oldpath = self::_make_path($url, $name);
		$newpath = self::_make_path($url, $new);
		
		if(file_exists($oldpath) && !file_exists($path)) {
			return rename($oldpath, $newpath);
		}
		
		return false;
	}
	
	/**
	 *	@desc Edit a file
	 *  @param Filename
	 *  @param Content
	 *  @param Append
	 *  @param Url
	 *  @return Boolean 
	 */
	static function write($name, $content = '', $append = false, $url = false) {
		
		// Sort our urls and paths out.
		$path = self::_make_path($url, $name);
		
		if(file_exists($path) && is_writable($path)) {
			
			// Open the file stream
			$h = fopen($path, ($append == false ? 'w' : 'a'));
			
			// Write to that file
			$write = fwrite($h, $content);
			
			// Close the stream
			fclose($h);
			
			return $write;
		}
		
		// Throw an error.
		Error::log($path . ': Does not exist or is not writable.');
		
		return false;
		
	}
	
	/**
	 *	@desc Check if file exists
	 *	@param Filename
	 *  @return Boolean
	 */
	static function exists($filename) {
		return is_file($filename) && file_exists($filename);
	}
	
	/**
	 *	@desc Check if file is writable
	 *	@param Filename
	 *  @return Boolean
	 */
	static function writable($filename) {
		return is_writable($filename);
	}
	
	/**
	 *	@desc Check if file is readable
	 *	@param Filename
	 *  @return Boolean
	 */
	static function readable($filename) {
		return is_readable($filename);
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
	
	/**
	 *	@desc Generate a path using url and name
	 *  @param Url
	 *  @param Filename
	 *  @return String 
	 */
	private static function _make_path($url, $name) {
		if(!$url) $url = APP_BASE . 'files/';
		return $url . $name;
	} 
}