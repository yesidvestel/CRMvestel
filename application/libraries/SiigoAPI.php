<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/siigo_folder/CurlRequest.php';
$cReq = new CurlRequest();
function _log($msg) {
    echo date(DATE_ISO8601) . ": $msg\n";
}
class SiigoAPI
{
    private $urlToken;
    private $urlBase;
    private $apiUser;
    private $apiPassword;
    private $subscriptionKey;
    private $token = "";
    private $token2 = "";
    private $cReq = null;


    public function __construct()
    {
        $this->cReq = new CurlRequest();

        $config = parse_ini_file(dirname(__FILE__) . '/siigo_folder/siigoapi.conf', true);
        $this->urlToken = $config['server']['url_token'];
        $this->urlBase = $config['server']['url_base'];
        $this->apiUser = $config['user']['username'];
        $this->subscriptionKey = $config['server']['subscription_key'];
        $this->apiPassword = $config['user']['password'];
    }


    /**
     * Establece el token de acceso y obtiene información de autenticación
     * 
     * @return array Respuesta del servidor a la solicitud de autenticación
     */
    public function getAuth($cuenta)
    {
        $cuentaVESGATV=array("username"=>"contabilidad@vestel.com.co","access_key"=>"MDc2YzZlMzAtZGI2Yy00OGFkLWFjZjktZTNlNGUxNDZkODk5Ok9SUDkhOXowQ0E=");
        $cuentaVESGATELECOMUNICACIONES=array("username"=>"contabilidad@vestel.com.co","access_key"=>"YjMzZWY4MzYtMDMxMC00MjBlLTg0NzItZTAzYzFjMDcwMTc2OjQpcTh0Rk8hNkI=");
        $cuentaData=array();
        if($cuenta==1){
            $cuentaData=$cuentaVESGATV;
        }else{
            $cuentaData=$cuentaVESGATELECOMUNICACIONES;
        }
       // _log("Obteniendo autorización token"); //descomentar para depurar
        $postFields = [
            "username"=>$cuentaData['username'],
            "access_key"=>$cuentaData['access_key'],
        ];
        $cOptions = [
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
            ],
            CURLOPT_SSL_VERIFYPEER=>false,
        ];

        list($httpCode, $resp) = $this->cReq->curlPost(
            $this->urlToken, json_encode($postFields), $cOptions
        );

        if ($httpCode !== 200) {
            _log($resp);
            throw new Exception("Información de autenticación no válida");
        }

        $decodedResp = json_decode($resp, true);
        $this->token = $decodedResp['access_token'];

       // _log("Obtención de autorización terminada"); //descomentar para depurar

        return $resp;
    }

    public function getAuth2($cuenta)
    {
        $cuentaVESGATV=array("username"=>"contabilidad@vestel.com.co","access_key"=>"MDc2YzZlMzAtZGI2Yy00OGFkLWFjZjktZTNlNGUxNDZkODk5Ok9SUDkhOXowQ0E=");
        $cuentaVESGATELECOMUNICACIONES=array("username"=>"contabilidad@vestel.com.co","access_key"=>"YjMzZWY4MzYtMDMxMC00MjBlLTg0NzItZTAzYzFjMDcwMTc2OjQpcTh0Rk8hNkI=");
        $cuentaData=array();
        if($cuenta==1){
            $cuentaData=$cuentaVESGATV;
        }else{
            $cuentaData=$cuentaVESGATELECOMUNICACIONES;
        }
        //_log("Obteniendo autorización token"); //descomentar para depurar
        $postFields = [
            "username"=>$cuentaData['username'],
            "access_key"=>$cuentaData['access_key'],
        ];
        $cOptions = [
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
            ],
            CURLOPT_SSL_VERIFYPEER=>false,
        ];

        list($httpCode, $resp) = $this->cReq->curlPost(
            $this->urlToken, json_encode($postFields), $cOptions
        );

        if ($httpCode !== 200) {
            _log($resp);
            throw new Exception("Información de autenticación no válida");
        }

        $decodedResp = json_decode($resp, true);
        $this->token2 = $decodedResp['access_token'];

        //_log("Obtención de autorización terminada"); //descomentar para depurar

        return $resp;
    }



    /**
     * Obtiene un listado de facturas
     * 
     * @param int $page Número de página que se quiere obtener
     * 
     * @return array Listado de facturas que se encuentran en la página indicada
     */
    public function getInvoices($page)
    {
        _log("Consultando facturas");
        $url = "{$this->urlBase}/Invoice/GetAll?numberPage=$page&namespace=v1";
        $i = 0;
        do {
            $cOptions = [
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$this->token}",
                    "Content-Type: application/json",
                    "Ocp-Apim-Subscription-Key: {$this->subscriptionKey}",
                ],
            ];
            list($httpCode, $resp) = $this->cReq->curlGet($url, [], $cOptions);
            if ($httpCode === 401) {
                $this->getAuth();
            }
            $i += 1;
        } while ($i < 2 && $httpCode === 401);
        _log("Consulta de facturas finalizada [$httpCode]");

        return json_decode($resp, true);
    }
/**
     * Obtiene un listado de facturas
     * 
     * @param int $page Número de página que se quiere obtener
     * 
     * @return array Listado de facturas que se encuentran en la página indicada
     */
    public function getCustomer($document,$cuenta)
    {
    if($cuenta==1){
        $tokenx=$this->token;
    }else{
        $tokenx=$this->token2;
    }
        //_log("Consultando facturas");
        //$this->getAuth($cuenta);
        $url = "{$this->urlBase}/customers?identification=".$document;
        $i = 0;
        do {
            $cOptions = [
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "Authorization: Bearer $tokenx",
                ],
                CURLOPT_SSL_VERIFYPEER=>false,
            ];
            list($httpCode, $resp) = $this->cReq->curlGet($url, [], $cOptions);
            if ($httpCode === 401) {
                //$this->getAuth($cuenta);
            }
            $i += 1;
        } while ($i < 2 && $httpCode === 401);
        //_log("Consulta de facturas finalizada [$httpCode]");

        return json_decode($resp, true);
    }

    /**
     * Guarda una factura
     * 
     * @param string $invoiceData Cadena en formato json con la información de
     * la factura.
     * 
     * @return string Respuesta enviada por el servidor
     */
    public function saveCustomer($invoiceData,$cuenta) {

        if($cuenta==1){
        $tokenx=$this->token;
    }else{
        $tokenx=$this->token2;
    }
        //_log("Enviando factura"); //descomentar para depurar
        $url = "{$this->urlBase}/customers";
        $i = 0;
        //$this->getAuth($cuenta);
        do {
            $cOptions = [
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "Authorization: Bearer $tokenx",
                    
                ],
                CURLOPT_SSL_VERIFYPEER=>false,
            ];

            list($httpCode, $resp)= $this->cReq->curlPost($url, $invoiceData, $cOptions);
            if ($httpCode === 401) {
               // $this->getAuth($cuenta);
            }
            $i += 1;
        } while ($i < 2 && $httpCode === 401);
        //_log("Envío de factura finalizado [$httpCode]"); //descomentar para depurar

        return array('respuesta' => $resp,"httpCode"=>$httpCode );
    }

    public function updateCustomer($invoiceData,$id,$cuenta) {
        $this->getAuth($cuenta);
       $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, "$this->urlBase/customers/".$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

        curl_setopt($ch, CURLOPT_POSTFIELDS, $invoiceData);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type: application/json",
          "Authorization: Bearer $this->token"
        ));

        $response = curl_exec($ch);
        curl_close($ch);
    }

    public function saveInvoice($invoiceData,$cuenta) {
        if($cuenta==1){
        $tokenx=$this->token;
    }else{
        $tokenx=$this->token2;
    }
        //_log("Enviando factura"); //descomentar para depurar
        $url = "{$this->urlBase}/invoices";
        $i = 0;
        //$this->getAuth($cuenta);
        do {
            $cOptions = [
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "Authorization: Bearer $tokenx",
                    
                ],
                CURLOPT_SSL_VERIFYPEER=>false,
            ];

            list($httpCode, $resp)= $this->cReq->curlPost($url, $invoiceData, $cOptions);
            if ($httpCode === 401) {
               // $this->getAuth($cuenta);
            }
            $i += 1;
        } while ($i < 4 && ($httpCode === 401 ));
        //_log("Envío de factura finalizado [$httpCode]"); //descomentar para depurar

        return array('respuesta' => $resp,"httpCode"=>$httpCode );
    }

    public function accionar($api,$invoiceData,$cuenta){
    	
        //var_dump($api->getInvoices(1));
        //$invoiceData = file_get_contents(dirname(__FILE__) . '/siigo_folder/invoice.json');
        $respuesta=$api->saveInvoice($invoiceData,$cuenta);
        /*echo "<br>";
        var_dump($respuesta);
        echo "<br>";
        
        var_dump($respuesta['httpCode']);*/
        try {
            if($respuesta['httpCode']==200 ||$respuesta['httpCode']==100 || $respuesta['httpCode']==0 || $respuesta['httpCode']==201){//100            
                return array('respuesta' =>$respuesta['respuesta'],"mensaje" =>"Factura Guardada");
            }else{
                return array('respuesta' =>$respuesta['respuesta'],"mensaje" =>"Ubo algun error");//falta imprimir en un alter el error
            }    
        } catch (Exception $e) {
               return array('respuesta' =>$respuesta['respuesta'],"mensaje" =>"Ubo algun error");//falta imprimir en un alter el error
        }
        
        
        
    }
}