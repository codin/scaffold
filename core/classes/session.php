<?php !defined('IN_APP') and header('location: /');

class Session {
	
	public function init() {
			
	}
	
	/**
	 *	@desc Set the session
	 *  @param Data
	 *  @return Boolean 
	 */
	public static function set($data) {
	
	}
	
	/**
	 *	@desc Get the session
	 *  @param Key
	 *  @return (object) Array 
	 */
	public static function get($key) {
	
	}
	
	/**
	 *	@desc Encode some stuff
	 *  @param Data
	 *  @return Data (encoded) 
	 */
	private function encode($data) {
		
		if(!empty($data)) {
			
			if(is_array($data)) {
				foreach($data as $key => $value) {
					$data['key'] = Crypt::encode($value);
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
	private function decode($data) {
		
		if(!empty($data)) {
			
			if(is_array($data)) {
				foreach($data as $key => $value) {
					$data['key'] = Crypt::decode($value);
				}
			} else {
				$data = Crypt::decode($data);
			}
			
			return $data;
		}
		
		return false;
	}
}