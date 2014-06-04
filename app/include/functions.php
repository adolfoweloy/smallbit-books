<?php
use ActiveRecord\DateTime;
define('APP_PATH', 'app');

/**
 * Load classes automatically.
 * 
 * @param type $className
 * @return type 
 */
function main_autoload($className) {

    $filePath = $className.'.php';

    $possibilities = array( 
        APP_PATH.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$filePath, 
        APP_PATH.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.$filePath, 
        APP_PATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.$filePath, 
        APP_PATH.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$filePath, 
        $filePath 
    ); 

    foreach ($possibilities as $file) {
        if (file_exists($file)) { 
            require_once($file); 
            return true;
        }
    }     

}

spl_autoload_register('main_autoload');

/**
 * Retrieves a GET parameter and if it was not set then a default value
 * will be returned based on $default_value argument.
 * 
 * @param type  $name parameter name retrieved by GET / querystring.
 * @param type  $default_value default value to return if GET parameter isn't set.
 * @return type string value returned by GET
 */
function get_default($name, $default_value) {

    if (!isset($_GET[$name])) {
        return $default_value;
    }

    if (empty($_GET[$name])) {
        return $default_value;
    }

    return $_GET[$name];
}

/**
 * Retrieves a POST parameter and if it was not set then a default value
 * will be returned based on $default_value argument.
 * 
 * @param type  $name parameter name retrieved by POST.
 * @param type  $default_value default value to return if POST parameter isn't set.
 * @return type string value returned by POST
 */
function post_default($name, $default_value = null) {

    if (!isset($_POST[$name])) {
        return $default_value;
    }

    if (empty($_POST[$name])) {
        return $default_value;
    }

    return trim($_POST[$name]);
}

/**
 * Retrieves a DateTime instance from a date field from form data.
 * @param string $name name of date form field
 * @return DateTime
 */
function post_date($name, $default_value = null) {
	$date = DateTime::createFromFormat('d/m/Y', post_default($name, $default_value));
	return $date;
}

/**
 * Indicates if this application is running in 
 * PROD [production mode]
 * @return boolean 
 */
function is_prod_env() {
	// TODO - isso deveria ficar no bootstrap
	return ENVIRONMENT == 'PROD';
}

/**
 * Retrieves the body content to be sent by mail when a new user
 * get an account from this website.
 * 
 * @param string $name - the user name
 * @param string $email - the email of this user
 * @param string $pwd - the password used to login
 * @return string 
 */
function get_registry_body_mail( $name, $email, $pwd ) {
	$content = file_get_contents(REGISTRY_BODY_MAIL);
	$content = str_replace('{name}', $name, $content);
	$content = str_replace('{email}', $email, $content);
	$content = str_replace('{pwd}', $pwd, $content);
	return $content;
}

/**
 * Retrieves the content of the term of use and conditions.
 * @return string
 */
function get_user_conditions() {
	return file_get_contents(USER_CONDITIONS_FILE);	
}

/**
 * funçao para gerar senhas
 * source: http://www.webtoolkit.info/php-random-password-generator.html
 * @param integer $length
 * @param integer $strength
 */
function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}