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
    return $result;
} catch (Exception $e) {
    echo 'Exception when calling SmsApi->sms: ', $e->getMessage(), PHP_EOL;
}
    	//$respuesta =$SmsApi->sms($SMSRequest);
    	//var_dump($respuesta);

    }

    public function alternativa_por_curl_envio_sms_invividual($token,$number,$mensaje){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.cellvoz.co/v2/sms/single',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "number": "57'.$number.'",
            "message": "'.$mensaje.'",
            "type": 1
            }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'api-key: 8529863e6706e0659cb610dfaded9c36db43e989',
            'Authorization: Bearer '.$token
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    } 
    public function envio_sms_masivos_por_curl($token,$number,$mensaje){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.cellvoz.co/v2/sms/multiple',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
              "name": "Mensaje Masivo",
              "sendingDate": "29/05/2021",
              "messages": [
                {
                  "number": "573142349563",
                  "message": "mensaje Duber",
                  "type": 1
                },
                {
                  "number": "573107614750",
                  "message": "mensaje Duber",
                  "type": 1
                }
              ]
            }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'api-key: 8529863e6706e0659cb610dfaded9c36db43e989',
            'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJnZXJlbmNpYUB2ZXN0ZWwuY29tLmNvIiwidXNlciI6eyJuYW1lcyI6bnVsbCwiYWNjb3VudCI6bnVsbCwiaWR2Ijo2OTUzLCJpZHMiOjcwNjgsInRpcG9DbGllbnRlIjozMiwic2FsZG8iOjgxNjE3LCJjdWVudGEiOiIwMDQ4NjgwMDQzMCIsImVtcHJlc2EiOiJWRVNHQSBURUxFQ09NVU5JQ0FDSU9ORVMgUyBBIFMiLCJub21icmUiOiJWRVNHQSBURUxFQ09NVU5JQ0FDSU9ORVMgUyBBIFMiLCJyYXpvblNvY2lhbCI6IlZFU0dBIFRFTEVDT01VTklDQUNJT05FUyBTIEEgUyIsInRpcG9QYWdvIjoiUHJlcGFnbyIsImNpdWRhZCI6ImJvZ290YSIsImRpcmVjY2lvbiI6ImNhbGxlIDk0YSAxMy00MiIsImRvY3VtZW50byI6Ijg0NDAwNDk3OSIsImVtYWlsIjoiZ2VyZW5jaWFAdmVzdGVsLmNvbS5jbyIsInRlbGVmb25vIjoiMzEwNjA5NTY3NSIsImNvcnRlIjoiMTk4OC0wMS0wMSIsInRpcG9TdWJ1c3VhcmlvIjpudWxsLCJjbGF2ZSI6bnVsbH0sImlhdCI6MTYyMjMwMTYzNSwiZXhwIjoxNjIyMzg4MDM1fQ.dU0fmyB2bbXJfxb4-uP_A1bvtryNWq2m2QwR6Csrazs'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
 ?>