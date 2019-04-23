# Omnipay: PayU

**PayU driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements PayU Online Payment Gateway support for Omnipay.

PayU REST API 2.1 [documentation](http://developers.payu.com/en/restapi.html)

This implementation uses OAuth 2

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "bileto/omnipay-payu": "~0.1.1"
    }
}
```
## TL;DR
```php
<?php
require 'vendor/autoload.php';

use Omnipay\PayU\GatewayFactory;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// default is official sandbox
$posId = isset($_ENV['POS_ID']) ? $_ENV['POS_ID'] : '300046';
$secondKey = isset($_ENV['SECOND_KEY']) ? $_ENV['SECOND_KEY'] : '0c017495773278c50c7b35434017b2ca';
$oAuthClientSecret = isset($_ENV['OAUTH_CLIENT_SECRET']) ? $_ENV['OAUTH_CLIENT_SECRET'] : 'c8d4b7ac61758704f38ed5564d8c0ae0';

$gateway = GatewayFactory::createInstance($posId, $secondKey, $oAuthClientSecret, true);

try {
    $orderNo = '12345677';
    $returnUrl = 'http://localhost:8000/gateway-return.php';
    $description = 'Shopping at myStore.com';

    $purchaseRequest = [
        'customerIp'    => '127.0.0.1',
        'continueUrl'   => $returnUrl,
        'merchantPosId' => $posId,
        'description'   => $description,
        'currencyCode'  => 'PLN',
        'totalAmount'   => 15000,
        'exOrderId'     => $orderNo,
        'buyer'         => (object)[
            'email'     => 'test@example.com',
            'firstName' => 'Peter',
            'lastName'  => 'Morek',
            'language'  => 'pl'
        ],
        'products'      => [
            (object)[
                'name'      => 'Lenovo ThinkPad Edge E540',
                'unitPrice' => 15000,
                'quantity'  => 1
            ]
        ],
        'payMethods'    => (object) [
            'payMethod' => (object) [
                'type'  => 'PBL', // this is for card-only forms (no bank transfers available)
                'value' => 'c'
            ]
        ]
    ];

    $response = $gateway->purchase($purchaseRequest);

    echo "TransactionId: " . $response->getTransactionId() . PHP_EOL;
    echo 'Is Successful: ' . (bool) $response->isSuccessful() . PHP_EOL;
    echo 'Is redirect: ' . (bool) $response->isRedirect() . PHP_EOL;

    // Payment init OK, redirect to the payment gateway
    echo $response->getRedirectUrl() . PHP_EOL;
} catch (\Exception $e) {
    dump((string)$e);
}
```

For custom sandbox payu gateway prepare `.env` file based on `.env-default`.

## Test cards

### Positive authorization 

| Card provider | Card number
|---|---
|VISA | 4010968243274
|VISA | 4006566732412511
|MAESTRO | 5000579348745235
|MAESTRO | 6999631853158960001
|MASTER CARD| 5100052384536818

### Negative authorization 

| Card provider | Card number
|---|---
|VISA | 4000398284279
|VISA | 4000949177144979
|MAESTRO | 5000105018126595
|MAESTRO | 5794651333329448
|MASTER CARD | 5599575752298650

The expiration date of cards range should be valid date range, value CVC / CVV2 (3 random digits).
Sandbox environment doesn't support 3DS.
