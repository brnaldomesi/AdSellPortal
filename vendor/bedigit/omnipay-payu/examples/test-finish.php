<?php

require '../vendor/autoload.php';

use Omnipay\PayU\GatewayFactory;

$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

// default is official sandbox
$posId = isset($_ENV['POS_ID']) ? $_ENV['POS_ID'] : '300046';
$secondKey = isset($_ENV['SECOND_KEY']) ? $_ENV['SECOND_KEY'] : '0c017495773278c50c7b35434017b2ca';
$oAuthClientSecret = isset($_ENV['OAUTH_CLIENT_SECRET']) ? $_ENV['OAUTH_CLIENT_SECRET'] : 'c8d4b7ac61758704f38ed5564d8c0ae0';

$gateway = GatewayFactory::createInstance($posId, $secondKey, $oAuthClientSecret, true);

try {
    $completeRequest = ['transactionReference' => 'J9R4JP3F2G160825GUEST000P01'];
    $response = $gateway->completePurchase($completeRequest);

    echo "Is Successful: " . $response->isSuccessful() . PHP_EOL;
    echo "TransactionId: " . $response->getTransactionId() . PHP_EOL;
    echo "State code: " . $response->getCode() . PHP_EOL;
    echo "PaymentId: " , $response->getTransactionReference() . PHP_EOL;
    echo "Data: " . var_export($response->getData(), true) . PHP_EOL;

} catch (\Exception $e) {
    dump($e->getResponse()->getBody(true));
    dump((string)$e);
}