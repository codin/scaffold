<?php 

/**
 *   Scaffold, a tiny PHP webapp framework.
 *
 *   @author	Codin' Co. <hi@codin.co>
 *   @version	2.0.0-alpha
 *   @package	Scaffold
 *
 *   A super-simple stopwatch to work out how fast Scaffold really is.
 */
 
namespace Scaffold\Helpers;

class Timer {
	/**
	 *   Our start time. Use when debugging at the START of the app,
	 *   weirdly enough.
	 */
	public static $start = 0;
	
	/**
	 *   And - you guessed it - this is the end of the timer. We'll
	 *   use this to measure the speed once the app's done.
	 */
	public static $stop = 0;
	
	/**
	 *   Start your engines!
	 */
	public static function start() {
		if(self::$start == 0) {
			self::$start = microtime();
		}
	}
	
	public static function stop() {
		$now = microtime();
		
		if($now > self::$stop) {
			self::$stop = microtime();
		}
	}
	
	/**
	 *   Find the time. Returns in ms.
	 */
	public static function time() {
		self::stop();
		
		return self::$start - self::$stop;
	}
}