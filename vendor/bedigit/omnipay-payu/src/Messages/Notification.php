<?php


namespace Omnipay\PayU\Messages;


use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\NotificationInterface;
use OpenPayU_Util;
use stdClass;
use Symfony\Component\HttpFoundation\Request;

class Notification implements NotificationInterface
{
    const OPEN_PAY_U_SIGNATURE = 'OpenPayU-Signature';
    const X_OPEN_PAY_U_SIGNATURE = 'X-OpenPayU-Signature';

    /** @var stdClass */
    private $cachedData = null;

    /** @var Request */
    private $httpRequest;

    /** @var Client|ClientInterface */
    private $httpClient;

    /** @var string */
    private $secondKey;

    public function __construct($httpRequest, $httpClient, $secondKey)
    {
        $this->httpRequest = $httpRequest;
        $this->httpClient = $httpClient;
        $this->secondKey = $secondKey;
    }

    /**
     * {
     * "order":{
     * "orderId":"LDLW5N7MF4140324GUEST000P01",
     * "extOrderId":"Order id in your shop",
     * "orderCreateDate":"2012-12-31T12:00:00",
     * "notifyUrl":"http://tempuri.org/notify",
     * "customerIp":"127.0.0.1",
     * "merchantPosId":"{POS ID (pos_id)}",
     * "description":"My order description",
     * "currencyCode":"PLN",
     * "totalAmount":"200",
     * "buyer":{
     * "email":"john.doe@example.org",
     * "phone":"111111111",
     * "firstName":"John",
     * "lastName":"Doe",
     * "language":"en"
     * },
     * "products":[
     * {
     * "name":"Product 1",
     * "unitPrice":"200",
     * "quantity":"1"
     * }
     * ],
     * "status":"COMPLETED"
     * },
     * "localReceiptDateTime": "2016-03-02T12:58:14.828+01:00",
     * "properties": [
     * {
     * "name": "PAYMENT_ID",
     * "value": "151471228"
     * }
     * ]
     * }*/

    /**
     * Gateway Reference
     *
     * @return string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        if (isset($this->getData()->order->extOrderId) && !empty($this->getData()->order->extOrderId)) {
            return (string) $this->getData()->order->extOrderId;
        }

        return null;
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        if (!$this->cachedData) {
            $content = trim($this->httpRequest->getContent());

            $incomingSignature = $this->getSignature($this->httpRequest);

            $sign = OpenPayU_Util::parseSignature($incomingSignature);

            if (OpenPayU_Util::verifySignature($content, $sign->signature, $this->secondKey, $sign->algorithm)) {
                $this->cachedData = json_decode($content);
            } else {
                throw new InvalidRequestException('Invalid signature - ' . $sign->signature);
            }
        }

        return $this->cachedData;
    }

    /**
     * @param Request $request
     * @return string
     * @throws InvalidRequestException
     */
    private function getSignature(Request $request)
    {
        if ($request->headers->has(self::OPEN_PAY_U_SIGNATURE)) {
            return $request->headers->get(self::OPEN_PAY_U_SIGNATURE);
        } elseif ($request->headers->has(self::X_OPEN_PAY_U_SIGNATURE)) {
            return $request->headers->get(self::X_OPEN_PAY_U_SIGNATURE);
        }
        throw new InvalidRequestException('There is no ' . self::OPEN_PAY_U_SIGNATURE . ' or ' . self::X_OPEN_PAY_U_SIGNATURE . ' header present in request');
    }

    /**
     * Was the transaction successful?
     *
     * @return string Transaction status, one of {@see STATUS_COMPLETED}, {@see #STATUS_PENDING} or {@see #STATUS_FAILED}.
     * @throws InvalidRequestException
     */
    public function getTransactionStatus()
    {
        if ($this->getData()) {
            $status = $this->getData()->order->status;
            if (in_array($status, ['COMPLETED'], true)) {
                return self::STATUS_COMPLETED;
            } elseif (in_array($status, 'PENDING')) {
                return self::STATUS_PENDING;
            } elseif (in_array($status, ['CANCELLED', 'REJECTED'])) {
                return self::STATUS_FAILED;
            }
            throw new InvalidRequestException('We have received unknown status "' . $status . '"');
        }
    }

    /**
     * Response Message
     *
     * @return string A response message from the payment gateway
     */
    public function getMessage()
    {
        return $this->getData();
    }
}
