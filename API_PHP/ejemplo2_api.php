<?php
require_once "CurlRequest.php";

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
    private $cReq = null;


    public function __construct()
    {
        $this->cReq = new CurlRequest();

        $config = parse_ini_file('siigoapi.conf', true);
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
    public function getAuth()
    {
        _log("Obteniendo autorización");
        $postFields = [
            "grant_type" => "password",
            "username" => 'VesgaTelecomunicacionesSAS\\VesgaT49791@apionmicrosoft.com',
            "password" => 'h1U~@r339B',
            "scope" => "WebApi offline_access",
        ];
        $cOptions = [
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Authorization: Basic U2lpZ29XZWI6QUJBMDhCNkEtQjU2Qy00MEE1LTkwQ0YtN0MxRTU0ODkxQjYx",
                "Content-Type: application/x-www-form-urlencoded"
            ],
            CURLOPT_SSL_VERIFYPEER=>false,
        ];

        list($httpCode, $resp) = $this->cReq->curlPost(
            $this->urlToken, $postFields, $cOptions
        );

        if ($httpCode !== 200) {
            _log($resp);
            throw new Exception("Información de autenticación no válida");
        }

        $decodedResp = json_decode($resp, true);
        $this->token = $decodedResp['access_token'];

        _log("Obtención de autorización terminada");

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
     * Guarda una factura
     * 
     * @param string $invoiceData Cadena en formato json con la información de
     * la factura.
     * 
     * @return string Respuesta enviada por el servidor
     */
    public function saveInvoice($invoiceData) {
        _log("Enviando factura");
        $url = "{$this->urlBase}/Invoice/Save?namespace=1";
        $i = 0;
        
        do {
            $cOptions = [
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$this->token}",
                    "Content-Type: application/json",
                    "Ocp-Apim-Subscription-Key: {$this->subscriptionKey}",
                ],
                CURLOPT_POSTFIELDS => $invoiceData,
            ];
            list($httpCode, $resp)
                = $this->cReq->curlPost($url, [], $cOptions);
            if ($httpCode === 401) {
                $this->getAuth();
            }
            $i += 1;
        } while ($i < 2 && $httpCode === 401);
        _log("Envío de factura finalizado [$httpCode]");

        return $resp;
    }
}




$token = '';
$api = new SiigoAPI();
var_dump($api->getInvoices(1));
$invoiceData = file_get_contents("invoice.json");
var_dump($api->saveInvoice($invoiceData));