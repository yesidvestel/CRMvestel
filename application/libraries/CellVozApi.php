<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/cellvoz_folder/SwaggerClient/vendor/autoload.php';

use Swagger\Client\Api\AuthApi;
use Swagger\Client\Model\Login;
class CellVozApi
{
	public function __construct()
    {
    }

    public function getToken(){
    	$AuthApi = new AuthApi();
		$login = new Login( array('account' =>"00486800430","password"=>"Admin2019"));
		var_dump($AuthApi->login($login));
    }
}
 ?>