# Swagger\Client\SmsApi

All URIs are relative to *https://api.cellvoz.com/v2*

Method | HTTP request | Description
------------- | ------------- | -------------
[**sms**](SmsApi.md#sms) | **POST** /sms/single | Enviar mensajes de texto sencillos, para el envio se debe enviar el JWT Token y el API Key

# **sms**
> \Swagger\Client\Model\SMSResponse sms($body)

Enviar mensajes de texto sencillos, para el envio se debe enviar el JWT Token y el API Key

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
    // Configure HTTP bearer authorization: bearerAuth
    $config = Swagger\Client\Configuration::getDefaultConfiguration()
    ->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Swagger\Client\Api\SmsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Swagger\Client\Model\SMSRequest(); // \Swagger\Client\Model\SMSRequest | Envio de un mensaje de texto para celulares, el formato del numero de celular debe ser codigopais+numero, Ejemplo  Telefono en Colombia 573113455666, la longitud del texto a enviar no debe superar los 140 caracteres.

try {
    $result = $apiInstance->sms($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SmsApi->sms: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\SMSRequest**](../Model/SMSRequest.md)| Envio de un mensaje de texto para celulares, el formato del numero de celular debe ser codigopais+numero, Ejemplo  Telefono en Colombia 573113455666, la longitud del texto a enviar no debe superar los 140 caracteres. |

### Return type

[**\Swagger\Client\Model\SMSResponse**](../Model/SMSResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

