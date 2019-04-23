<?php

namespace Omnipay\PayU;

use Omnipay\Common\AbstractGateway;
use Omnipay\PayU\Messages\Notification;

class Gateway extends AbstractGateway
{
	const URL_SANDBOX = 'https://secure.snd.payu.com';
	const URL_PRODUCTION = 'https://secure.payu.com';
	
	/**
	 * Get gateway display name
	 */
	public function getName()
	{
		return 'PayU';
	}
	
	/**
	 * @return \Omnipay\Common\Message\AbstractRequest
	 */
	public function getAccessToken()
	{
		$parameters = [
			'clientId'     => $this->getParameter('posId'),
			'clientSecret' => $this->getParameter('clientSecret'),
			'apiUrl'       => $this->getApiUrl(),
		];
		
		return $this->createRequest('\Omnipay\PayU\Messages\AccessTokenRequest', $parameters);
	}
	
	/**
	 * @param array $parameters
	 * @return \Omnipay\Common\Message\AbstractRequest
	 */
	public function purchase(array $parameters = [])
	{
		$accessToken = $this->getAccessToken()->send();
		$accessToken = $accessToken->getData();
		//dd($accessToken);
		
		$this->setAccessToken($accessToken);
		
		return $this->createRequest('\Omnipay\PayU\Messages\PurchaseRequest', $parameters);
	}
	
	/**
	 * @param array $parameters
	 * @return \Omnipay\Common\Message\AbstractRequest
	 */
	public function completePurchase(array $parameters = [])
	{
		$this->setAccessToken($this->getAccessToken()->getAccessToken());
		
		return $this->createRequest('\Omnipay\PayU\Messages\CompletePurchaseRequest', $parameters);
	}
	
	public function acceptNotification()
	{
		return new Notification($this->httpRequest, $this->httpClient, $this->getParameter('secondKey'));
	}
	
	/**
	 * @return string
	 */
	private function getApiUrl()
	{
		if ($this->getTestMode()) {
			return self::URL_SANDBOX;
		} else {
			return self::URL_PRODUCTION;
		}
	}
	
	public function getDefaultParameters()
	{
		return [
			'posId'        => '',
			'secondKey'    => '',
			'clientSecret' => '',
			'testMode'     => true,
			'posAuthKey'   => null,
		];
	}
	
	/**
	 * @param string $secondKey
	 */
	public function setSecondKey($secondKey)
	{
		$this->setParameter('secondKey', $secondKey);
	}
	
	/**
	 * @param string $posId
	 */
	public function setPosId($posId)
	{
		$this->setParameter('posId', $posId);
	}
	
	/**
	 * @param string $clientSecret
	 */
	public function setClientSecret($clientSecret)
	{
		$this->setParameter('clientSecret', $clientSecret);
	}
	
	/**
	 * @param string|null $posAuthKey
	 */
	public function setPosAuthKey($posAuthKey = null)
	{
		$this->setParameter('posAuthKey', $posAuthKey);
	}
	
	public function initialize(array $parameters = [])
	{
		parent::initialize($parameters);
		$this->setApiUrl($this->getApiUrl());
		
		return $this;
	}
	
	private function setApiUrl($apiUrl)
	{
		$this->setParameter('apiUrl', $apiUrl);
	}
	
	private function setAccessToken($accessToken)
	{
		$this->setParameter('accessToken', $accessToken);
	}
}