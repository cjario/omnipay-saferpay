<?php

namespace Omnipay\Saferpay\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    const BASE_URL = 'https://www.saferpay.com/api';
    const BASE_URL_TEST = 'https://test.saferpay.com/api';

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

        return base64_encode($this->getUsername().':'.$this->getPassword());
    }

    protected function sendRequest($uri, $data)
    {

        $url = "{$this->getEndpoint()}{$uri}";
        $postData = $this->getData();
        $headers = [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Authorization' => 'Basic '. $this->getAuthCredentials(),

        ];
        $httpResponse = $this->httpClient->post($url, $headers, json_encode($postData))->send()->json();

        return $this->createResponse($httpResponse);
    }

    protected function createResponse($response)
    {
        return $this->response = new Response($this, $response);
    }

    protected function getEndpoint()
    {
        return ($this->getTestMode() ? self::BASE_URL_TEST : self::BASE_URL);
    }
}
