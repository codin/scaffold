<?php 

/**
 *   Scaffold, a tiny PHP webapp framework.
 *
 *   @author	Codin' Co. <hi@codin.co>
 *   @version	2.0.0-alpha
 *   @package	Scaffold
 *
 *   Here goes nothin’.
 */
 
namespace Scaffold;

class View {
	public function init() {
		return $this;
	}
	
	public function render($text) {
		echo $text;
	}
}