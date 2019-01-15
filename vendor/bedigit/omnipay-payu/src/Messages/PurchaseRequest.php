<?php

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

class PurchaseRequest extends AbstractRequest
{
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
	 * @return array
	 */
	public function getData()
	{
		return $this->getParameters();
	}
	
	/**
	 * Send the request with specified data
	 *
	 * Example: https://payu21.docs.apiary.io/#reference/api-endpoints/order-api-endpoint/create-a-new-order
	 *
	 * @param  mixed $data The data to send
	 * @return ResponseInterface
	 */
	public function sendData($data)
	{
		$headers = [
			'Accept'          => 'application/json',
			'Content-Type'    => 'application/json',
			'allow_redirects' => ['max' => 0, 'strict' => true, 'track_redirects' => true],
		];
		if (isset($data['accessToken']) && isset($data['accessToken']['access_token'])) {
			$headers['Authorization'] = 'Bearer ' . $data['accessToken']['access_token'];
		}
		
		$apiUrl = $data['apiUrl'] . '/api/v2_1/orders';
		
		if (isset($data['purchaseData']['extOrderId'])) {
			$this->setTransactionId($data['purchaseData']['extOrderId']);
		}
		
		$httpResponse = $this->httpClient->request($this->getHttpMethod(), $apiUrl, $headers, json_encode($data['purchaseData']));
		
		$data = json_decode($httpResponse->getBody()->getContents(), true);
		
		return new PurchaseResponse($this, $data);
	}
	
	/**
	 * @param string $apiUrl
	 */
	public function setApiUrl($apiUrl)
	{
		$this->setParameter('apiUrl', $apiUrl);
	}
	
	/**
	 * @param array $data
	 */
	public function setPurchaseData($data)
	{
		$this->setParameter('purchaseData', $data);
	}
	
	/**
	 * @param string $accessToken
	 */
	public function setAccessToken($accessToken)
	{
		$this->setParameter('accessToken', $accessToken);
	}
	
}