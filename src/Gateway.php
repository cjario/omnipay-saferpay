<?php

namespace Omnipay\Saferpay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Helper;
use Symfony\Component\HttpFoundation\ParameterBag;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Saferpay';
    }

    public function getDefaultParameters()
    {
        $settings = parent::getDefaultParameters();
        return $settings;
    }

    public function initialize(array $parameters = array())
    {
        $this->parameters = new ParameterBag;

        // set default parameters
        foreach ($this->getDefaultParameters() as $key => $value) {
            if (is_array($value)) {
                $this->parameters->set($key, reset($value));
            } else {
                $this->parameters->set($key, $value);
            }
        }

        Helper::initialize($this, $parameters);
        return $this;
    }

    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    public function setAccountId($value)
    {
        return $this->setParameter('accountId', $value);
    }

    public function setUsername($username)
    {
        $this->setParameter('username', $username);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setPassword($password)
    {
        $this->setParameter('password', $password);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function getAuthCredentials()
    {
        $this->validate('username', 'password');

        return base64_encode($this->getUsername() . ':' . $this->getPassword());
    }


    /**
     * Create an authorize request.
     *
     * @param array $parameters
     * @return \Omnipay\Saferpay\Message\AuthorizeRequest
     */
    public function authorize(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Saferpay\Message\AuthorizeRequest', $parameters);
    }

    /**
     * Create an capture request.
     *
     * @param array $parameters
     * @return \Omnipay\Saferpay\Message\CaptureRequest
     */
    public function capture(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Saferpay\Message\CaptureRequest', $parameters);
    }

    /**
     * Create an cancel request.
     *
     * @param array $parameters
     * @return \Omnipay\Saferpay\Message\CancelRequest
     */
    public function cancel(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Saferpay\Message\CancelRequest', $parameters);
    }

    /**
     * Create an assertion request.
     *
     * @param array $parameters
     * @return \Omnipay\Saferpay\Message\AssertRequest
     */
    public function assert(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Saferpay\Message\AssertRequest', $parameters);
    }

    /**
     * Create a purchase request.
     *
     * @param array $parameters
     * @return \Omnipay\Saferpay\Message\AuthorizeRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->authorize($parameters);
    }
}
