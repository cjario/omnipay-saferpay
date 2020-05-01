<?php

namespace Omnipay\Saferpay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

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
        return isset($this->data['Transaction']['Status']) && $this->data['Transaction']['Status'] == 'AUTHORIZED' ? true : false;
    }

    public function isAuthorized()
    {
        return isset($this->data['Transaction']['Status']) && $this->data['Transaction']['Status'] == 'AUTHORIZED' ? true : false;
    }

    public function isCaptured()
    {
        return isset($this->data['Transaction']['Status']) && $this->data['Transaction']['Status'] == 'CAPTURED' ? true : false;
    }

    public function getTransactionReference()
    {
        if ($this->isCaptured()) {
            return isset($this->data['Transaction']['CaptureId']) ? $this->data['Transaction']['CaptureId'] : null;
        }
        return isset($this->data['Transaction']['Id']) ? $this->data['Transaction']['Id'] : null;
    }

}
