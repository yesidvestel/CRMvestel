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
    
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.liwa.co/v2/auth/login',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "account": "'.$_SESSION['variables_cellvoz']->account.'",
  "password": "'.$_SESSION['variables_cellvoz']->password.'"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Accept: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

return array("token"=>json_decode($response)->token);

    }

    public function enviar_msm($token,$number,$mensaje){
   
    	//$respuesta =$SmsApi->sms($SMSRequest);
    	//var_dump($respuesta);
$curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.liwa.co/v2/sms/single',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 399,
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
            'api-key: '.$_SESSION['variables_cellvoz']->api_key,
            'Authorization: Bearer '.$token
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }

    public function alternativa_por_curl_envio_sms_invividual($token,$number,$mensaje){
        $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.liwa.co/v2/sms/single',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 399,
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
            'api-key: '.$_SESSION['variables_cellvoz']->api_key,
            'Authorization: Bearer '.$token
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    } 
    public function envio_sms_masivos_por_curl($token,$mensaje,$name_campaign){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.liwa.co/v2/sms/multiple',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 399,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
              "name": "'.$name_campaign.'",
              "messages": [
                    '.$mensaje.'
              ]
            }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'api-key: '.$_SESSION['variables_cellvoz']->api_key,
            'Authorization: Bearer '.$token
          ),
        ));


        $response = curl_exec($curl);
/*if($errno = curl_errno($curl)) {
    $error_message = curl_strerror($errno);
    echo "cURL error ({$errno}):\n {$error_message}";
}*/
        curl_close($curl);

        return $response;

        /* es orden de los datos que resive este servidor
        {
              "name": "masivo",
              "messages": [
                {
                  "codeCountry": "57",
                  "number": "3142349563",
                  "message": "mensaje Duber CRM 2",
                  "type": 1
                },
                {
                  "codeCountry": "57",
                  "number": "3107614750",
                  "message": "mensaje Duber CRM 2",
                  "type": 1
                }
              ]
            }
        */
    }
    public function envio_sms_masivos_por_curl_2($token,$mensaje,$name_campaign){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.liwa.co/v2/sms/multiple',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
              "name": "masiva",
              "messages": [
                    {
                              "codeCountry": "57",
                              "number": "3142349563",
                              "message": "Estimado JAIRO vestel informa, su estado de cuenta de el mes de Junio ha sido generado su saldo es $ 235.000 pago oportuno 20-06-2021 si ya pago Omitir",
                              "type": 1
                            },               {
                              "codeCountry": "57",
                              "number": "3142349563",
                              "message": "Estimado CESAR vestel informa, su estado de cuenta de el mes de Junio ha sido generado su saldo es $ 50.000 pago oportuno 20-06-2021 si ya pago Omitir",
                              "type": 1
                            }
              ]
            }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'api-key: 8529863e6706e0659cb610dfaded9c36db43e989',
            'Authorization: Bearer '.$token
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

        /* es orden de los datos que resive este servidor
        {
              "name": "masivo",
              "messages": [
                {
                  "codeCountry": "57",
                  "number": "3142349563",
                  "message": "mensaje Duber CRM 2",
                  "type": 1
                },
                {
                  "codeCountry": "57",
                  "number": "3107614750",
                  "message": "mensaje Duber CRM 2",
                  "type": 1
                }
              ]
            }
        */
    }
}
 ?>