<?php

namespace Omnipay\TwoCheckoutPlus\Message;


/**
 * Purchase Request.
 *
 * @method PurchaseResponse send()
 */
class TokenPurchaseRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://www.2checkout.com/checkout/api/1/';
    protected $testEndpoint = 'https://sandbox.2checkout.com/checkout/api/1/';

    /**
     * Build endpoint.
     *
     * @return string
     */
    public function getEndpoint()
    {
        $endpoint = $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;

        return $endpoint . $this->getAccountNumber() . '/rs/authService';
    }

    public function isNotNull($value)
    {
        return !is_null($value);
    }
	
	/**
	 * Get HTTP Method.
	 *
	 * This is nearly always POST but can be over-ridden in sub classes.
	 *
	 * @return string
	 */
	public function getHttpMethod()
	{
		return 'POST';
	}

    /**
     * HTTP request headers.
     *
     * @return array
     */
    public function getRequestHeaders()
    {
        return array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        );
    }

    /**
     * @return array
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('accountNumber', 'privateKey', 'token', 'amount', 'transactionId');

        $data = array();
        $data['sellerId'] = $this->getAccountNumber();
        $data['privateKey'] = $this->getPrivateKey();
        $data['merchantOrderId'] = $this->getTransactionId();
        $data['token'] = $this->getToken();
        $data['currency'] = $this->getCurrency();
        $data['total'] = $this->getAmount();

        if ($this->getCard()) {
            $data['billingAddr']['name'] = $this->getCard()->getName();
            $data['billingAddr']['addrLine1'] = $this->getCard()->getAddress1();
            $data['billingAddr']['addrLine2'] = $this->getCard()->getAddress2();
            $data['billingAddr']['city'] = $this->getCard()->getCity();
            $data['billingAddr']['state'] = $this->getCard()->getState();
            $data['billingAddr']['zipCode'] = $this->getCard()->getPostcode();
            $data['billingAddr']['email'] = $this->getCard()->getEmail();
            $data['billingAddr']['country'] = $this->getCard()->getCountry();
            $data['billingAddr']['phoneNumber'] = $this->getCard()->getPhone();
            $data['billingAddr']['phoneExt'] = $this->getCard()->getPhoneExtension();
        }

        if ($this->getCart()) {
            // remove amount parameter if lineItem attributes / cart is set
            unset($data['total']);

            $data['lineItems'] = $this->getCart();
        }

        // remove null values item from $data['billingAddr']
        $data['billingAddr'] = array_filter($data['billingAddr'], array($this, 'isNotNull'));

        // remove null values item from $data.
        $data = array_filter($data, array($this, 'isNotNull'));

        return $data;
    }

    /**
     * @param mixed $data
     *
     * @return TokenPurchaseResponse
     */
    public function sendData($data)
    {
		$httpResponse = $this->httpClient->request(
			$this->getHttpMethod(),
			$this->getEndpoint(),
			$this->getRequestHeaders(),
			json_encode($data)
		);
	
		$data = json_decode($httpResponse->getBody()->getContents(), true);
	
		return new TokenPurchaseResponse($this, $data);
    }
}
