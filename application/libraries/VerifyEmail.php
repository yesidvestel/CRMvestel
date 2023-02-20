<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once dirname(__FILE__) . '/validate_email/autoload.php';
class VerifyEmail { 
	public function validate($email){
		$validator = new SMTPValidateEmail\Validator($email, 'sender@example.org');
		$results   = $validator->validate();
		if($results[$email]){
			return true;
		}else{
			return false;
		}
	}

} 

 ?>