<?php

namespace Omnipay\TwoCheckoutPlus\Message;


/**
 * Purchase Request.
 *
 * @method PurchaseResponse send()
 */
class RefundRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://www.2checkout.com/api/sales/refund_invoice';
    protected $testEndpoint = 'https://sandbox.2checkout.com/api/sales/refund_invoice';

    /**
     * Get appropriate 2checkout endpoints.
     *
     * @return string
     */
    public function getEndPoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
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
        );
    }

    public function isNotNull($value)
    {
        return !is_null($value);
    }
	
	public function getHttpMethod()
	{
		return 'POST';
	}

    public function getData()
    {
        $this->validate('adminUsername', 'adminPassword', 'saleId', 'comment');

        $data = array();
        $data['admin_username'] = $this->getAdminUsername();
        $data['admin_password'] = $this->getAdminPassword();

        $data['sale_id'] = $this->getSaleId();
        $data['invoice_id'] = $this->getInvoiceId();
        $data['amount'] = $this->getParameter('amount');
        $data['currency'] = $this->getCurrency();
        $data['comment'] = 'Buyer deserved a refund';
        $data['category'] = 10;

        // override default category value of 10.
        // see https://www.2checkout.com/documentation/api/sales/refund-invoice
        if ($this->getCategory()) {
            $data['category'] = $this->getCategory();
        }

        // override default comment
        if ($this->getComment()) {
            $data['comment'] = $this->getComment();
        }

        // override default comment
        if (strlen($this->getCurrency()) > 3) {
            $data['currency'] = strtolower($this->getCurrency());
        }

        // needed to determine which API endpoint to use in OffsiteResponse
        if ($this->getTestMode()) {
            $data['sandbox'] = true;
        }

        $data = array_filter($data, function ($value) {
            return !is_null($value);
        });

        // remove unwanted data
        unset($data['sandbox']);

        return $data;
    }


    /**
     * @param mixed $data
     *
     * @return RefundResponse
     */
    public function sendData($data)
    {
        $payload = $data;
        unset($payload['admin_username']);
        unset($payload['admin_password']);
	
		$headers = $this->getRequestHeaders();
		if (
			(isset($data['admin_username']) && !empty($data['admin_username'])) &&
			(isset($data['admin_password']) && !empty($data['admin_password']))
		) {
			$headers['Authorization'] = 'Basic ' . base64_encode($data['admin_username'] . ':' . $data['admin_password']);
		}
	
		$httpResponse = $this->httpClient->request(
			$this->getHttpMethod(),
			$this->getEndpoint(),
			$headers,
			$payload
		);
	
		$data = json_decode($httpResponse->getBody()->getContents(), true);
	
		return new RefundResponse($this, $data);
    }
}
