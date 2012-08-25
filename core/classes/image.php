<?php !defined('IN_APP') and header('location: /');

class Image {
	
	public function __construct($src = false) {
	    
	    //  Handle stupid calls
	    if(!is_string($src)) return;
	    
	    //  Load the image
	    if($src = File::get($src)) {
	        $this->image = $src;
	    }
	    
	    return $this;
	}
}