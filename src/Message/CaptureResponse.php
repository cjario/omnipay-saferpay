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
class CaptureResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return isset($this->data['Status']) && $this->data['Status'] == 'CAPTURED' ? true : false;
    }

    public function getTransactionReference()
    {
        return isset($this->data['CaptureId']) ? $this->data['CaptureId'] : null;
    }

}
