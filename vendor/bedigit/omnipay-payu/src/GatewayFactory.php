<?php

namespace Omnipay\PayU;

use Omnipay\Omnipay;
use Symfony\Component\HttpFoundation\Request;

class GatewayFactory
{
    /**
     * @param string $posId
     * @param string $secondKey (MD5)
     * @param string $oAuthClientSecret (MD5)
     * @param bool $isSandbox
     * @param string|null $posAuthKey
     * @param Request|null $httpRequest
     * @return Gateway
     */
    public static function createInstance($posId, $secondKey, $oAuthClientSecret, $isSandbox = false, $posAuthKey = null, Request $httpRequest = null)
    {
        /** @var \Omnipay\PayU\Gateway $gateway */
        $gateway = Omnipay::create('PayU', null, $httpRequest);
        $gateway->initialize([
            'posId' => $posId,
            'secondKey' => $secondKey,
            'clientSecret' => $oAuthClientSecret,
            'testMode' => $isSandbox,
            'posAuthKey' => $posAuthKey,
        ]);
        return $gateway;
    }
}