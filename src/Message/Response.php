<?php

namespace Omnipay\Saferpay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Saferpay Response
 *
 * This is the response class for all Saferpay requests.
 *
 * @see \Omnipay\Saferpay\Gateway
 */
class Response extends AbstractResponse
{
    public function isSuccessful()
    {
        return isset($this->data->success) && $this->data->success;
    }

    public function getTransactionReference()
    {
        return $this->data['reference'] ?? null;
    }

    public function getMessage()
    {
        return $this->data['message'] ?? null;
    }
}
