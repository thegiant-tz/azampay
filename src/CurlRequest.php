<?php

namespace Thegiant\Azampay;

class CurlRequest
{
    public $auth_url;
    public $base_url;
    function __construct()
    {
        $this->auth_url = isLiveMode() ? '' : 'https://authenticator-sandbox.azampay.co.tz/AppRegistration/GenerateToken';
        $this->base_url = isLiveMode() ? '' : 'https://sandbox.azampay.co.tz';
    }


    private static function curlpost($url, $data, $request = 'POST', $headers = ['Content-Type: application/json'])
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $request,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $headers,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public static function post($endpoint, $data, $headers = null)
    {
        return CurlRequest::curlpost((new self)->base_url . $endpoint, $data, 'POST', $headers);
    }

    public static function authenticate()
    {
        return CurlRequest::post((new self)->auth_url, [
            "appName" => env('AZAMPAY_APP_NAME'),
            "clientId" => env('AZAMPAY_CLIENT_ID'),
            "clientSecret" => env('AZAMPAY_CLIENT_SECRET'),
        ]);
    }

    public static function get($endpoint, $data, $headers = null)
    {
        return CurlRequest::curlpost((new self)->base_url . $endpoint, $data, 'GET', $headers);
    }
}
