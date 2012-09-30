<?php !defined('IN_APP') and header('location: /');

class Cache {


	public static function set($key, $value) {
		// If its not cached we add it
		if(!isCached() || Config::get('cache.autoupdate')) {
			return self::update($key, $value);
		}

		return false;
	}

	public static function update($key, value) {
		if(!self::isCacheFile($key)) {
			self::_createFile($key);
		}

		// If now is later than when it was set and the content is not the same
		if(self::getChangeTime($key) < time() && self::_getContent($key) != $value) {
			// update
			return self::_setContent($key, $value);
		}
	}

	public static function isCached($key) {
		return false;
	}

	public static function get($key) {

	}
}