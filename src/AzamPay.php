<?php

namespace Thegiant\Azampay;

use Thegiant\Azampay\CurlRequest;

class AzamPay
{

    static function authenticate()
    {
        return json_decode(CurlRequest::authenticate());
    }

    static function mnoCheckout($accountNumber, $amount, $provider, $externalId,  $additionalProperties = null, $currency = 'TZS')
    {
        return CurlRequest::post('/azampay/mno/checkout', [
            'accountNumber' => $accountNumber,
            'amount' => $amount,
            'currency' => $currency ?? 'TZS',
            'externalId' => $externalId,
            'additionalProperties' => $additionalProperties,
            'provider' => $provider,
        ], [
            'Authorization' => 'Bearer ' .
                AzamPay::authenticate()->data->accessToken,
        ]);
    }
}
