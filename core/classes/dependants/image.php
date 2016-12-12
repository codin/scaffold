<?php !defined('IN_APP') and header('location: /');

class Image {
	public static $extensions = array('png', 'jpg', 'jpeg', 'gif');
	public $newImage;
	public $src;
	public $image;
	public $name;
	public $created;
	
	public function __construct($src = false) {
		
		//  Handle stupid calls
		if(!is_string($src)) return;
		
		//  Load the image
		if(file_exists($src)) {
			$this->image = $src;
			$this->src = $src;
			$this->name = $this->_parseName($src);
			
			if(!$this->name) {
				Error::create('Invalid, unknown, or just plain dodgy file type.');
			} else {
				//  Create an image, not an error
				$this->created = $this->create();
			}
		} else {
			Error::create('There doesn&rsquo;t seem to be an image at ' . $src);
		}
				
		return $this;
	}
	
	public function resize($width, $height = 'square') {
		//  Only bother processing if we have an image
		if($this->created) {
			//  Get image dimensions
			$imageWidth = imagesx($this->image);
			$imageHeight = imagesy($this->image);
			
			//  Handle widths and heights and stuffs
			if(!is_numeric($width)) $width = $imageWidth;
			if($height === 'square') $height = $width;
			
			$this->dimensions = array($width, $height);
			
			$this->newImage = imagecreatetruecolor($width, $height);
			
			//  Recreate the image
			imagecopyresized(
				//  Old path, new path
				$this->newImage, $this->image,
				
				//  Old x, old y, new x, new y
				0, 0, 0, 0,
				
				//  Old/new dimensions
				$width, $height, $imageWidth, $imageHeight
			);
		} else {
			Error::create('Wait, what am I resizing?');
		}
		
		return $this;
	}
	
	public function desaturate() {
		return $this;
	}
	
	public function create() {
		if(isset($this->name)) {
			$this->image = call_user_func('imagecreatefrom' . $this->name['extension'], $this->image);
		}
		
		return is_resource($this->image);
	}
	
	//  Generate a link to the image
	public function link() {
		return $this->_store();
	}
	
	private function _create() {
		if(is_resource($this->newImage)) {
			ob_start();
			
			//  Create the image
			call_user_func(
				'image' . $this->name['extension'],
				$this->newImage, Config::get('image.cache'), Config::get('image.quality', 90)
			);
			
			return ob_get_clean();
		}
	}
	
	private function _store() {
		$name = $this->name['filename'] . '_' . join('x', $this->dimensions) . '.' . $this->name['extension'];
		
		if(!@file_put_contents(Config::get('image.cache') . $name, $this->_create())) {
			return Config::get('image.cache') . $name;
		} else {
			Error::create('Could not save image file. Please check the cache folder exists and is writable.');
		}
		
		return false;
	}
	
	private function _parseName($file) {
		//  Strip out any directory names
		$file = basename($file);
		
		//  Split into potential extensions
		$file = explode('.', $file);
		
		//  Get a count of potential extensions, accounting for zero-indexing
		$count = count($file) - 1;

		//  Store the last one
		$last = $file[$count];
		
		//  Check it's a legit file extension
		if(in_array($last, self::$extensions)) {
			//  Remove the extension, we'll separate that
			unset($file[$count]);
			
			return array(
				'filename' => join('.', $file),
				'extension' => str_replace('jpg', 'jpeg', $last)
			);
		}
		
		//  Something has gone terribly wrong
		return false;
	}
}