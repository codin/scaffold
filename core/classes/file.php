<?php !defined('IN_APP') and header('location: /');

class File {
	
	/**
	 *	@desc Get a file
	 *  @param Filename
	 *  @param Character Limit
	 *	@param Path/URL
	 *  @return (object) Array 
	 */
	public static function get($name, $char_limit = 10, $url = false) {
		
		// Sort our urls and paths out.
		$path = self::_makePath($url, $name);
		
		// If the file exists
		if(file_exists($path) and is_readable($path)) {
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
	public static function delete($name, $url = false) {
		$path = self::_makePath($url, $name);
		
		// if its a directory
		if(is_dir($path)) {
			return rmdir($path);
		}
		
		// if its a file
		if(is_file($path) and file_exists($path)) {
			return @unlink($path);
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
	public static function rename($name, $new, $url = false) {
		$oldpath = self::_makePath($url, $name);
		$newpath = self::_makePath($url, $new);
		
		if(self::exists($oldpath) and !self::exists($path)) {
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
	public static function write($name, $content = '', $append = false, $url = false) {
		
		// Sort our urls and paths out.
		$path = self::_makePath($url, $name);

		if(self::writable($path) or self::writable($url)) {
			
			// Open the file stream
			$h = fopen($path, ($append == false ? 'w' : 'a'));

			// Write to that file
			$write = fwrite($h, $content);
			
			// Close the stream
			fclose($h);
			
			return $write;
		}
		
		return false;
		
	}
	
	/**
	 *	@desc Check if file is writable
	 *	@param Filename
	 *  @return Boolean
	 */
	public static function writable($filename) {
		return self::exists($filename) and is_writable($filename);
	}
	
	/**
	 *	@desc Check if file is readable
	 *	@param Filename
	 *  @return Boolean
	 */
	public static function readable($filename) {
		return self::exists($filename) and is_readable($filename);
	}
	
	/**
	 *	@desc Check if file exists
	 *	@param Filename
	 *  @return Boolean
	 */
	public static function exists($filename) {
		return file_exists($filename);
	}
	
	/**
	 *	@desc What type is a file?
	 *  @param File location
	 *  @return String
	 */
	public static function type($filename) {
		return filetype($filename);
	}
	
	/**
	 *	@desc Upload a file
	 *  @param Destination
	 *  @return Boolean 
	 */
	public static function upload($dest = '') {
		// Store it in another variable to make it look nicer
		$file = $_FILES['file'];
		$file['ext'] = end(explode(".", $file["name"]));
		
		// If an error return false
		if($file['error'] > 0) return false;
		
		// Use default if its empty
		if(empty($dest)) $dest = Config::get('file.default_store');
		
		// If everything is ok, upload it
		if($file['size'] < Config::get('file.max_upload') and in_array($file['ext'], Config::get('file.allowed_types'))) {
			return self::_move($file['tmp_name'], $dest . $file['name']);
		}
		
		return false;
	}
	
	/**
	 *	@desc Move a file from temp location
	 *  @param Temp location
	 *  @param Destination
	 *  @return Boolean 
	 */
	private static function _move($temp, $dest) {
		return move_uploaded_file($temp, $dest);
	}
	
	/**
	 *	@desc Generate a path using url and name
	 *  @param Url
	 *  @param Filename
	 *  @return String 
	 */
	private static function _makePath($url, $name) {
		if(!$url) $url = APP_BASE . 'files/';
		return $url . $name;
	} 
}