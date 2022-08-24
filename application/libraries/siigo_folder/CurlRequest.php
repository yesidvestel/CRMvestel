<?php
/**
 * Abstracciones para CURL, basado en:
 * https://www.php.net/manual/es/function.curl-exec.php#98628
 */

class CurlRequest
{
    /**
    * Send a POST request using cURL
    * @param string $url to request
    * @param array $post values to send
    * @param array $options for cURL
    * @return string
    */
    function curlPost($url, $post = NULL, array $options = [])
    {
        $defaults = [
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_POSTFIELDS => $post
        ];

        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if( ! $result = curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [ $code, $result ];
    }


    /**
    * Send a GET request using cURL
    * @param string $url to request
    * @param array $get values to send
    * @param array $options for cURL
    * @return string
    */
    function curlGet($url, $get = NULL, array $options = array())
    {   
        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 0
        );
    
        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if( ! $result = curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [ $code, $result ];
    }
}