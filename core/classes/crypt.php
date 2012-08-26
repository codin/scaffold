<?php !defined('IN_APP') and header('location: /');

class Crypt {
	
	private static $encode_method, $salt;
	
	public function init() {

	}
	
	/** 
	 *	@desc Encode some data
	 *  @param Data
	 *  @return Boolean / Data (encoded)
	 */
	public static function encode($data) {
		
		var_dump(Config::get('crypt'));
		
		if(method_exists(__CLASS__, '_' . Config::get('crypt.encode_method'))) {
			return call_user_func_array(__CLASS__ . '::_' . Config::get('crypt.encode_method'), array($data, 'encode'));
		}
		
		return false;	
	}
	
	/** 
	 *	@desc Decode some data
	 *  @param Data (encoded)
	 *  @return Boolean / Data (decoded)
	 */
	public static function decode($data) {

		if(method_exists(__CLASS__, '_' . Config::get('crypt.encode_method'))) {
			return call_user_func_array(__CLASS__ . '::_' . Config::get('crypt.encode_method'), array($data, 'decode'));
		}
		
		return false;
		
	}
	
	/** 
	 *	@desc Base 64 encoding/decoding
	 *  @param Data
	 *  @param Type
	 *  @return Boolean / String
	 */
	private function _base64($data, $type = 'encode') {
		
		if(empty($data)) return false;
		
		if($type == 'encode') {
			$data = base64_encode($data . Config::get('crypt.salt'));
		} else if($type == 'decode') {
			$data = str_replace(Config::get('crypt.salt'), '', base64_decode($data));
		}
		
		return $data;
	}
}	