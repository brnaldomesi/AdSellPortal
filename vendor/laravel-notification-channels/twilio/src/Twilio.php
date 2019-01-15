<?php

namespace NotificationChannels\Twilio;

use Twilio\Rest\Client as TwilioService;
use NotificationChannels\Twilio\Exceptions\CouldNotSendNotification;

class Twilio
{
    /**
     * @var TwilioService
     */
    protected $twilioService;

    /**
     * @var TwilioConfig
     */
    private $config;

    /**
     * Twilio constructor.
     *
     * @param  TwilioService $twilioService
     * @param TwilioConfig $config
     */
    public function __construct(TwilioService $twilioService, TwilioConfig $config)
    {
        $this->twilioService = $twilioService;
        $this->config = $config;
    }

    /**
     * Send a TwilioMessage to the a phone number.
     *
     * @param  TwilioMessage $message
     * @param  string $to
     * @param bool $useAlphanumericSender
     * @return mixed
     * @throws CouldNotSendNotification
     */
    public function sendMessage(TwilioMessage $message, $to, $useAlphanumericSender = false)
    {
        if ($message instanceof TwilioSmsMessage) {
            if ($useAlphanumericSender && $sender = $this->getAlphanumericSender()) {
                $message->from($sender);
            }

            return $this->sendSmsMessage($message, $to);
        }

        if ($message instanceof TwilioCallMessage) {
            return $this->makeCall($message, $to);
        }

        throw CouldNotSendNotification::invalidMessageObject($message);
    }

    /**
     * Send an sms message using the Twilio Service.
     *
     * @param TwilioSmsMessage $message
     * @param string $to
     * @return \Twilio\Rest\Api\V2010\Account\MessageInstance
     * @throws CouldNotSendNotification
     */
    protected function sendSmsMessage(TwilioSmsMessage $message, $to)
    {
        $params = [
            'from' => $this->getFrom($message),
            'body' => trim($message->content),
        ];

        if ($serviceSid = $this->config->getServiceSid()) {
            $params['messagingServiceSid'] = $serviceSid;
        }

        $this->fillOptionalParams($params, $message, [
            'statusCallback',
            'statusCallbackMethod',
            'applicationSid',
            'maxPrice',
            'provideFeedback',
            'validityPeriod',
        ]);

        if ($message instanceof TwilioMmsMessage) {
            $this->fillOptionalParams($params, $message, [
                'mediaUrl',
            ]);
        }

        return $this->twilioService->messages->create($to, $params);
    }

    /**
     * Make a call using the Twilio Service.
     *
     * @param TwilioCallMessage $message
     * @param string $to
     * @return \Twilio\Rest\Api\V2010\Account\CallInstance
     * @throws CouldNotSendNotification
     */
    protected function makeCall(TwilioCallMessage $message, $to)
    {
        $params = [
            'url' => trim($message->content),
        ];

        $this->fillOptionalParams($params, $message, [
            'statusCallback',
            'statusCallbackMethod',
            'method',
            'status',
            'fallbackUrl',
            'fallbackMethod',
        ]);

        return $this->twilioService->calls->create(
            $to,
            $this->getFrom($message),
            $params
        );
    }

    /**
     * Get the from address from message, or config.
     *
     * @param TwilioMessage $message
     * @return string
     * @throws CouldNotSendNotification
     */
    protected function getFrom(TwilioMessage $message)
    {
        if (! $from = $message->getFrom() ?: $this->config->getFrom()) {
            throw CouldNotSendNotification::missingFrom();
        }

        return $from;
    }

    /**
     * Get the alphanumeric sender from config, if one exists.
     *
     * @return string|null
     */
    protected function getAlphanumericSender()
    {
        if ($sender = $this->config->getAlphanumericSender()) {
            return $sender;
        }
    }

    /**
     * @param array $params
     * @param TwilioMessage $message
     * @param array $optionalParams
     * @return mixed
     */
    protected function fillOptionalParams(&$params, $message, $optionalParams)
    {
        foreach ($optionalParams as $optionalParam) {
            if ($message->$optionalParam) {
                $params[$optionalParam] = $message->$optionalParam;
            }
        }
    }
}
