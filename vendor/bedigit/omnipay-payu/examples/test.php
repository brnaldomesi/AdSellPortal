<?php

require '../vendor/autoload.php';

use Guzzle\Http\Exception\ClientErrorResponseException;
use Omnipay\PayU\GatewayFactory;

$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

// default is official sandbox
$posId = isset($_ENV['POS_ID']) ? $_ENV['POS_ID'] : '300046';
$secondKey = isset($_ENV['SECOND_KEY']) ? $_ENV['SECOND_KEY'] : '0c017495773278c50c7b35434017b2ca';
$oAuthClientSecret = isset($_ENV['OAUTH_CLIENT_SECRET']) ? $_ENV['OAUTH_CLIENT_SECRET'] : 'c8d4b7ac61758704f38ed5564d8c0ae0';

$gateway = GatewayFactory::createInstance($posId, $secondKey, $oAuthClientSecret, true);

try {
    $orderNo = uniqid();
    $returnUrl = 'http://localhost:8000/gateway-return.php';
    $notifyUrl = 'http://127.0.0.1/uuid/notify';
    $description = 'Shopping at myStore.com';

    $purchaseRequest = [
        'purchaseData' => [
            'customerIp'    => '127.0.0.1',
            'continueUrl'   => $returnUrl,
            'notifyUrl'     => $notifyUrl,
            'merchantPosId' => $posId,
            'description'   => $description,
            'currencyCode'  => 'PLN',
            'totalAmount'   => 15000,
            'extOrderId'    => $orderNo,
            'buyer'         => (object)[
                'email'     => 'jan.machala+payu@bileto.com',
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
            'payMethods'    => (object)[
                'payMethod' => (object)[
                    'type'  => 'PBL', // this is for card-only forms (no bank transfers available)
                    'value' => 'c'
                ]
            ]
        ]
    ];

    $response = $gateway->purchase($purchaseRequest);

    echo "TransactionId: " . $response->getTransactionId() . PHP_EOL;
    echo "TransactionReference: " . $response->getTransactionReference() . PHP_EOL;
    echo 'Is Successful: ' . (bool)$response->isSuccessful() . PHP_EOL;
    echo 'Is redirect: ' . (bool)$response->isRedirect() . PHP_EOL;

    // Payment init OK, redirect to the payment gateway
    echo $response->getRedirectUrl() . PHP_EOL;
} catch (ClientErrorResponseException $e) {
    dump((string)$e);
    dump($e->getResponse()->getBody(true));
}