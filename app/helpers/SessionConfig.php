<?php

/**
 * Put here all your session configurations 
 * @author adolfo
 */
class SessionConfig {
	public static function build() {
		
		$_SESSION["WEBMASTER"] = array(
			'USERNAME' 	=> 'webmasterusername',
			'PWD' 		=> 'password',
			'EMAIL' 	=> 'webmaster@site.com',
			'DESCRIPTION' => 'website admin'
		);
		
	}
}