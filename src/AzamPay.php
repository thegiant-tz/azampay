<?php 
namespace Thegiant\Azampay;

class AzamPay {

    static function authenticate() {
        return CurlRequest::authenticate();
    }

    static function mnoCheckout($data) {
        return CurlRequest::post('/azampay/mno/checkout', $data);
    }
}