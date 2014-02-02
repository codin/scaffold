<?php !defined('IN_APP') and header('location: /');

class CSRF {
	
	/**
	 *  @desc Genearate a token
	 *  @return Boolean
	 */
	public static function generate() {
		
		// Get the current tokens
		$tokens = Session::get('tokens');
		
		// Create a new one
		$tokens[] = Crypt::encrypt(str_shuffle(Config::get('csrf.salt')), '6g67ba321', 'md5');
		
		// Set it in the session
		Session::set('tokens', $tokens);
		
		return !!Session::get('tokens');
	}
	
	/**
	 *  @desc Check if its a real token
	 *  @return Boolean
	 */
	public static function valid($token) {
		
		$tokens = Session::get('tokens');
		
		if($i = array_search($token, $tokens)) {
			// Remove them
			unset($tokens[$i]);
			
			// Reset it
			Session::set('tokens', $tokens);
			
			return true;
		}
		
		return false;
	}
}