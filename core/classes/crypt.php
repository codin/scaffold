<?php !defined('IN_APP') and header('location: /');

class Crypt {
	
	public function init() {

	}
	
	/** 
	 *	@desc Encode some data
	 *  @param Data
	 *  @return Boolean / Data (encoded)
	 */
	public static function encode($data) {
	    return self::doMethod(Config::get('crypt.encode_method'), 'encode', $data . Config::get('crypt.salt'));	
	}
	
	/** 
	 *	@desc Decode some data
	 *  @param Data (encoded)
	 *  @return Boolean / Data (decoded)
	 */
	public static function decode($data) {
		return str_replace(Config::get('crypt.salt'), '', self::doMethod(Config::get('crypt.encode_method'), 'decode', $data));
	}
	
	/** 
	 *	@desc Encode some data
	 *  @param Data
	 *  @return Boolean / Data (encoded)
	 */
	public static function encrypt($data) {
	    return self::doMethod(Config::get('crypt.encrypt_method'), 'encrypt', $data . Config::get('crypt.salt'));	
	}
	
	/** 
	 *	@desc Encoding, Decoding and Encryption methods
	 *  @param Method name
	 *  @param Type of method
	 *  @param Parameter
	 *  @return String
	 */
	private static function doMethod($name, $type, $param) {
		
		$methods = array(
			'encode' => array(
				'base64' => create_function('$stuff', 'return base64_encode($stuff);'),
				'rot13' => create_function('$stuff', 'return str_rot13($stuff);')
			),
			
			'decode' => array(
				'base64' => create_function('$stuff', 'return base64_decode($stuff);'),
				'rot13' => create_function('$stuff', 'return str_rot13($stuff);'),
			),
			
			'encrypt' => array(
				'des' => create_function('$stuff', 'return crypt($stuff);'),
				'md5' => create_function('$stuff', 'return md5($stuff);'),
				'sha1' => create_function('$stuff', 'return sha1($stuff);'),
				'sha256' => create_function('$stuff', 'return hash("sha256", $stuff);'),
				'sha512' => create_function('$stuff', 'return hash("sha512", $stuff);'),
				'blowfish ' => create_function('$stuff', 'return hash("blowfish", $stuff);'),
				'whirlpool' => create_function('$stuff', 'return hash("whirlpool", $stuff);')
			)
		);
		

		$func = $methods[strtolower($type)][strtolower($name)];
		
		return $func($param);
		
	}
}	