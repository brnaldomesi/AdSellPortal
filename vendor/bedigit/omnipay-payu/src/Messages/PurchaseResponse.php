<?php

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
	/**
	 * @return boolean
	 */
	public function isSuccessful()
	{
		if ('SUCCESS' !== $this->data['status']['statusCode']) {
			return false;
		}
		$redirectUrl = $this->getRedirectUrl();
		
		return is_string($redirectUrl);
	}
	
	/**
	 * Gets the redirect target url.
	 */
	public function getRedirectUrl()
	{
		if (isset($this->data['redirectUri']) && is_string($this->data['redirectUri'])) {
			return $this->data['redirectUri'];
		} else {
			return null;
		}
	}
	
	/**
	 * Get the required redirect method (either GET or POST).
	 */
	public function getRedirectMethod()
	{
		return 'GET';
	}
	
	/**
	 * Gets the redirect form data array, if the redirect method is POST.
	 */
	public function getRedirectData()
	{
		return null;
	}
	
	/**
	 * @return string|null
	 */
	public function getTransactionId()
	{
		if (isset($this->data['extOrderId']) && !empty($this->data['extOrderId'])) {
			return (string)$this->data['extOrderId'];
		}
		if (isset($this->request->getParameters()['transactionId']) && !empty($this->request->getParameters()['transactionId'])) {
			return $this->request->getParameters()['transactionId'];
		}
		
		return null;
	}
	
	/**
	 * PayU orderId
	 * @return string
	 */
	public function getTransactionReference()
	{
		if (isset($this->data['orderId']) && !empty($this->data['orderId'])) {
			return (string)$this->data['orderId'];
		}
		return null;
	}
	
	public function isRedirect()
	{
		return isset($this->data['redirectUri']) && is_string($this->data['redirectUri']);
	}
	
	/**
	 * @return null|string
	 */
	public function getCode()
	{
		return isset($this->data['status']) ? $this->data['status']['code'] : null;
	}
	
	/**
	 * @return null|string
	 */
	public function getMessage()
	{
		return isset($this->data['status']) ? $this->data['status']['statusDesc'] : null;
	}
}