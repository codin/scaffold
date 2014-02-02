<?php !defined('IN_APP') and header('location: /');

class Session {
	
	public static function init() {
		session_start();		
	}
	
	/**
	 *	@desc Set the session
	 *  @param Key
	 *	@param Data
	 *  @return Boolean 
	 */
	public static function set($key, $data) {
		
		$_SESSION[$key] = $data = (Config::get('session.encoded') == true ? self::_encode($data) : $data);
		
		if(Config::get('session.cookies')) {
		
			if(is_array($data) or is_object($data)) {
				$data = json_encode($data);
			}
			
			setcookie($key, $data, Config::get('session.expires'));
			
			return true;
		}
		
		return isset($_SESSION[$key]);
	}
	
	/**
	 *	@desc Get the session
	 *  @param Key
	 *  @return Data / Boolean 
	 */
	public static function get($key) {
		if(self::exists($key)) {
			
			if(Config::get('session.encoded')) {
				return self::_decode($_SESSION[$key]);
			}
			
			return $_SESSION[$key];
		}
		
		return false;
	}
	
	/**
	 *	@desc Is the session set?
	 *  @param Key
	 *  @return Boolean 
	 */
	public static function exists($key) {
		return isset($_SESSION[$key]);
	}
	
	/**
	 *	@desc Destroy the session
	 */
	public static function destroy($key) {
		unset($_SESSION[$key]);
		return setcookie($key, false, -1);
	}
	
	/**
	 *	@desc Encode some stuff
	 *  @param Data
	 *  @return Data (encoded) 
	 */
	private function _encode($data) {
		
		if(!empty($data)) {
			
			if(is_array($data)) {
				foreach($data as $key => $value) {
					$data[$key] = Crypt::encode($value);
				}
			} else {
				$data = Crypt::encode($data);
			}
			
			return $data;
		}
		
		return false;
	}
	
	/**
	 *	@desc Decode some data
	 *  @param Data (encoded)
	 *  @return Data 
	 */
	private function _decode($data) {
		
		if(!empty($data)) {
			
			if(is_array($data)) {
				foreach($data as $key => $value) {
					$data[$key] = Crypt::decode($value);
				}
			} else {
				$data = Crypt::decode($data);
			}
			
			return $data;
		}
		
		return false;
	}
}