<?php !defined('IN_APP') and header('location: /');

class Crypt {
	
	private static $encode_method = 'base64';
	
	public function init() {
		$conf = Config::get('crypt');
		self::$encode_method = $conf['encode_method'];
		self::$salt = $conf['salt'];
	}
	
	/** 
	 *	@desc Encode some data
	 *  @param Data
	 *  @return Boolean / Data (encoded)
	 */
	public static function encode($data) {
		
		if(empty($data)) return false;
		
		switch(self::$encode_method) {
			default:
				$data = $this->_base64($data, 'encode');
			break;
		}
		
		return $data;	
	}
	
	/** 
	 *	@desc Decode some data
	 *  @param Data (encoded)
	 *  @return Boolean / Data (decoded)
	 */
	public static function decode($data) {
		
		if(empty($data)) return false;
		
		switch(self::$encode_method) {
			default:
				$data = $this->_base64($data, 'decode');
			break;
		}
		
		return $data;
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
			$data = base64_encode($data . self::$salt);
		} else if($type == 'decode') {
			$data = base64_decode($data);
		}
		
		return $data;
	}
}	