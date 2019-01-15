<?php
namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractResponse;

class AccessTokenResponse extends AbstractResponse
{

    /**
     * @return boolean
     */
    public function isSuccessful()
    {
        return is_array($this->data)
            && isset($this->data['access_token'])
            && is_string($this->data['access_token'])
            && isset($this->data['token_type'])
            && is_string($this->data['token_type']);
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        $completeToken = sprintf('%s %s', ucfirst($this->data['token_type']), $this->data['access_token']);

        return $completeToken;
    }

}