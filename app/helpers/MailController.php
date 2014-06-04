<?php
require_once ("Mail.php");
require_once ("Mail/mime.php");

/**
 * Mail Controller. 
 * Creates a facade to provide a simpler using of Pear::Mail
 * See configurations within bootstrap.php
 *  
 * @author adolfo
 */
class MailController {

	/** application logger */
	private $logger = null;
	/** webmaster account definitions regarding bootstrap.php */
	private $webmaster = null;
	
	/** images to attach to email body */
	private $images = array();
	
	/** defines array position of image element thet determines the path to the image */
	private static $IMG_PATH = 1;
	
	/** defines array position of image element thet determines image reference (the reference to be used on html content cid) */
	private static $IMG_REFERENCE = 0;
	
	/** class constructor */
	public function __construct() {
		$this->logger = Logger::getLogger(__CLASS__);
		$this->webmaster = $_SESSION['WEBMASTER'];	
	}
	
	/**
	 * Append an image definition to be attached to the mail.
	 * The format of the imagem argument must be <code>array('image_reference' => 'path_to_the_image')</code>
	 * 
	 * @param array $image
	 * @throws Exception
	 */
	public function add_image($image = array()) {
		if (count($image) != 1) {
			throw new Exception("Invalid usage of MailController->add_image. This method expects 2 arguments", 9999, null);
		}
		
		array_push($this->images, $image);
	}
	
	/**
	 * Provides a simpler way to send an email via Pear::Mail
	 * 
	 * @param string $from
	 * @param string $username
	 * @param string $pwd
	 * @param string $to
	 * @param string $subject
	 * @param string $body
	 * @param boolean $is_html  indicates if there is html body within this email
	 */
	public function send( $from, $username, $pwd, $to, $subject, $body, $is_html = false ) {

		$headers =
			array (
				'From'    => $from, 
				'To'      => $to,
				'Subject' => $subject,
				'Date'    =>  date('D , d Mdd Y H:i:s O')
			);
		
		$params =
			array (
				'auth' 		=> true, 
				'host' 		=> SMTP_SERVER, 
				'username' 	=> $username,
				'password' 	=> $pwd
			);

		// if this is an html content body, uses mime definitions
		if ($is_html) {
			$enc = 'utf-8';
			
			$mime = new Mail_mime(array(
			    'eol' => "\n",
			    'text_encoding' => $enc,
			    'html_encoding' => $enc,
			    'html_charset' => $enc,
			    'text_charset' => $enc
			));
			
			$mime->setTXTBody($body);
			$mime->setHTMLBody($body);
			
			foreach ($this->images as $img) {
				
				$mime->addHTMLImage(
					$img[1], 
					"application/octet-stream", 
					$img[1], true, 
					$img[0]);
			}
			
			$body = $mime->get();
			$headers = $mime->headers($headers);
		}
		
		$mail = Mail::factory('smtp', $params);
		$result = $mail->send( $to, $headers, $body );

		if (PEAR::IsError($result))  {
			$error = "ERRO ao tentar enviar o email. (" . $result->getMessage(). ")";
			$this->logger->error($error);
			return false;
		}

		return true;		
	}

 }