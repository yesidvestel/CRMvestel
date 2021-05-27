<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/cellvoz_folder/SwaggerClient/vendor/autoload.php';

use Swagger\Client\Api\AuthApi;
use Swagger\Client\Model\Login;

use Swagger\Client\Api\SmsApi;
use Swagger\Client\Model\SMSRequest;
class CellVozApi
{
	public function __construct()
    {
    }
    public function getToken(){
    	$AuthApi = new AuthApi();
		$login = new Login( array('account' =>"00486800430","password"=>"Admin2019"));
		$x=$AuthApi->login($login);
		return $x;
    }
    public function enviar_msm($token,$number,$mensaje){
    	/*echo "<br>";
    	var_dump("token=> ".$token);
    	echo "<br>";
        echo "<br>";
        echo "<br>";*/
    	$config = Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken($token);
    	//$config->setApiKey("api-key","8529863e6706e0659cb610dfaded9c36db43e989");
    	$SmsApi= new SmsApi(new GuzzleHttp\Client(),$config);
    	//$SMSRequest= new SMSRequest(array("number"=>"573142349563","message"=>"MENSAJE PARA ENVIAR Duber"));
        $SMSRequest= new SMSRequest(array("number"=>"57".$number,"message"=>$mensaje));

    	try {
    $result = $SmsApi->sms($SMSRequest);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SmsApi->sms: ', $e->getMessage(), PHP_EOL;
}
    	//$respuesta =$SmsApi->sms($SMSRequest);
    	//var_dump($respuesta);

    }
}
 ?>