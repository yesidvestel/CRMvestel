<?php 
require_once dirname(__FILE__) . '/../../vendor/autoload.php';
use Swagger\Client\Api\AuthApi;
use Swagger\Client\Model\Login;
$AuthApi = new AuthApi();
$login = new Login( array('account' =>"00486800430","password"=>"Admin2019"));


var_dump($AuthApi->login($login));

 ?>