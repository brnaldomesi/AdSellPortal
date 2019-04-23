<?php

require '../vendor/autoload.php';

use Omnipay\PayU\GatewayFactory;
use Omnipay\PayU\Messages\Notification;
use Symfony\Component\HttpFoundation\Request;

$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

// default is official sandbox
$posId = isset($_ENV['POS_ID']) ? $_ENV['POS_ID'] : '300046';
$secondKey = isset($_ENV['SECOND_KEY']) ? $_ENV['SECOND_KEY'] : '0c017495773278c50c7b35434017b2ca';
$oAuthClientSecret = isset($_ENV['OAUTH_CLIENT_SECRET']) ? $_ENV['OAUTH_CLIENT_SECRET'] : 'c8d4b7ac61758704f38ed5564d8c0ae0';
$posAuthKey = isset($_ENV['POS_AUTH_KEY']) ? $_ENV['POS_AUTH_KEY'] : null; // Official sandbox does not provide signature key

$content = '{"order":{"orderId":"NN18KW7XJG160830GUEST000P01","extOrderId":"57c56b16d22e1","orderCreateDate":"2016-08-30T13:16:39.641+02:00","notifyUrl":"http://52.58.177.216/online-payments/uuid/notify","customerIp":"80.188.133.34","merchantPosId":"300293","description":"Shopping at myStore.com","currencyCode":"PLN","totalAmount":"15000","status":"PENDING","products":[{"name":"Lenovo ThinkPad Edge E540","unitPrice":"15000","quantity":"1"}]},"localReceiptDateTime":"2016-08-30T13:17:14.502+02:00","properties":[{"name":"PAYMENT_ID","value":"72829425"}]}';
$httpRequest = Request::create('/notify', 'POST', [], [], [], [], $content);
$httpRequest->headers->add(
    [
        'X-OpenPayU-Signature' => 'sender=checkout;signature=b640fa4baa73bb9e34f1cb8e5a5d4301;algorithm=MD5;content=DOCUMENT',
        'ContentType' => 'application/json'
    ]);
$gateway = GatewayFactory::createInstance($posId, $secondKey, $oAuthClientSecret, true, $posAuthKey, $httpRequest);

try {
    if (!$gateway->supportsAcceptNotification()) {
        echo "This Gateway does not support notifications";
    }

    $response = $gateway->acceptNotification();

    echo "PaymentId: " , $response->getTransactionReference() . PHP_EOL;
    echo "Message: " . $response->getMessage() . PHP_EOL;
    echo "Status: " . $response->getTransactionStatus() . PHP_EOL;
    echo "Data: " . var_export($response->getData(), true) . PHP_EOL;

} catch (\Exception $e) {
//    dump($e->getResponse()->getBody(true));
    dump((string)$e);
}