<?php

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractRequest;

class AccessTokenRequest extends AbstractRequest
{
	
	/** @var string */
	private $apiUrl;
	
	/**
	 * @param string $clientId
	 */
	public function setClientId($clientId)
	{
		$this->setParameter('clientId', $clientId);
	}
	
	/**
	 * @param string $clientSecret
	 */
	public function setClientSecret($clientSecret)
	{
		$this->setParameter('clientSecret', $clientSecret);
	}
	
	public function getHttpMethod()
	{
		return 'POST';
	}
	
	/**
	 * Example: https://payu21.docs.apiary.io/#introduction
	 *
	 * Request: client_credentials grant type
	 * ====================================================
	 *
	 * $ch = curl_init();
	 *
	 * curl_setopt($ch, CURLOPT_URL, "https://secure.payu.com/pl/standard/user/oauth/authorize");
	 * curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	 * curl_setopt($ch, CURLOPT_HEADER, FALSE);
	 *
	 * curl_setopt($ch, CURLOPT_POST, TRUE);
	 *
	 * curl_setopt($ch, CURLOPT_POSTFIELDS, grant_type=client_credentials&client_id=145227&client_secret=12f071174cb7eb79d4aac5bc2f07563f);
	 *
	 * curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	 *        "Content-Type: application/x-www-form-urlencoded"
	 * ));
	 *
	 * $response = curl_exec($ch);
	 * curl_close($ch);
	 *
	 * var_dump($response);
	 *
	 * ====================================================
	 * Response
	 * --------
	 * CODE: 200
	 * BODY:
	 * {
	 *        "access_token": "3e5cac39-7e38-4139-8fd6-30adc06a61bd",
	 *        "token_type": "bearer",
	 *        "refresh_token": "6e265a18-d33e-46d7-ae00-853adebbacfd",
	 *        "expires_in": 43199,
	 *        "grant_type": "clients_credentials"
	 * }
	 * ====================================================
	 *
	 * @param mixed $data
	 * @return \Omnipay\Common\Message\ResponseInterface|AccessTokenResponse
	 * @throws \Psr\Http\Client\Exception\NetworkException
	 * @throws \Psr\Http\Client\Exception\RequestException
	 */
	public function sendData($data)
	{
		$authorizeUrl = $this->apiUrl . '/pl/standard/user/oauth/authorize';
		
		$headers = [
			'Accept'       => 'application/json',
			'Content-Type' => 'application/x-www-form-urlencoded',
		];
		$data = $data ? http_build_query($data, '', '&') : null;
		
		$httpResponse = $this->httpClient->request($this->getHttpMethod(), $authorizeUrl, $headers, $data);
		
		$data = json_decode($httpResponse->getBody()->getContents(), true);
		
		return new AccessTokenResponse($this, $data);
	}
	
	/**
	 * @return array
	 */
	public function getData()
	{
		return [
			'grant_type'    => 'client_credentials',
			'client_id'     => $this->parameters->get('clientId'),
			'client_secret' => $this->parameters->get('clientSecret'),
		];
	}
	
	/**
	 * @param string $apiUrl
	 */
	public function setApiUrl($apiUrl)
	{
		$this->apiUrl = $apiUrl;
	}
}