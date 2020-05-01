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
        return true;
    }
}
