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
class AssertResponse extends AbstractResponse
{
    public function isRedirect()
    {
        return false;
    }

    public function isSuccessful()
    {
        return isset($this->data['Transaction']['Status']) && $this->data['Transaction']['Status'] == 'AUTHORIZED';
    }

    public function isAuthorized()
    {
        return isset($this->data['Transaction']['Status']) && $this->data['Transaction']['Status'] == 'AUTHORIZED';
    }

    public function isCaptured()
    {
        return isset($this->data['Transaction']['Status']) && $this->data['Transaction']['Status'] == 'CAPTURED';
    }

    public function getTransactionReference()
    {
        if ($this->isCaptured()) {
            return $this->data['Transaction']['CaptureId'] ?? null;
        }
        return $this->data['Transaction']['Id'] ?? null;
    }

}
