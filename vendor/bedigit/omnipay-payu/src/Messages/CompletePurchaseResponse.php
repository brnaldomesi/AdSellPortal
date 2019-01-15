<?php

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * @return boolean
     */
    public function isSuccessful()
    {
        return 'COMPLETED' === $this->getCode();
    }

    /**
     * @return string|null
     */
    public function getTransactionId()
    {
        if (isset($this->data['orders'][0]['extOrderId']) && !empty($this->data['orders'][0]['extOrderId'])) {
            return (string) $this->data['orders'][0]['extOrderId'];
        }

        return null;
    }

    public function isCancelled()
    {
        return in_array($this->getCode(), ['CANCELED', 'REJECTED'], true);
    }

    /**
     * PAYMENT_ID is not present for transaction in state PENDING
     * @return null|string
     */
    public function getTransactionReference()
    {
        if (isset($this->data['orders'][0]['orderId']) && !empty($this->data['orders'][0]['orderId'])) {
            return (string) $this->data['orders'][0]['orderId'];
        }

        return null;
    }

    /**
     * Status code (string)
     *
     * @return string
     */
    public function getCode()
    {
        return $this->data['orders'][0]['status'];
    }

    public function isPending()
    {
        return in_array($this->getCode(), ['PENDING', 'WAITING_FOR_CONFIRMATION', 'NEW']);
    }

    /**
     * @return string|null
     */
    public function getPaymentReference()
    {
        if (isset($this->data['properties'])) {
            $properties = $this->data['properties'];
            $paymentIdProperty = array_filter($properties, function ($item) {
                return $item['name'] === 'PAYMENT_ID';
            });
            if (isset($paymentIdProperty[0]['value'])) {
                return (string)$paymentIdProperty[0]['value'];
            }
        };

        return null;
    }
}