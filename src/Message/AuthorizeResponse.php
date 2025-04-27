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
class AuthorizeResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isRedirect()
    {
        return true;
    }
    public function isSuccessful()
    {
        return false;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getTransactionReference()
    {
        return $this->data['Token'] ?? null;
    }

    public function getRedirectUrl()
    {
        return $this->data['RedirectUrl'];
    }
    public function getRedirectData()
    {
        return [];
    }
}
