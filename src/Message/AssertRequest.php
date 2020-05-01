<?php

namespace Omnipay\Saferpay\Message;

class AssertRequest extends AbstractRequest
{
    protected $endpoint = '/Payment/v1/PaymentPage/Assert';

    public function setCustomerId($customerId)
    {
        $this->setParameter('customerId', $customerId);
    }

    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    public function getToken(){
        return $this->getParameter('token');
    }

    public function setToken($token){
        $this->setParameter('token', $token);
    }


    public function getData()
    {
        $this->validate('token', 'customerId');

        $requestData = [
            "RequestHeader" => [
                "SpecVersion" => "1.7",
                "CustomerId" => $this->getCustomerId(),
                "RequestId" => uniqid(),
                "RetryIndicator" => 0,
            ],
            "Token" => $this->getToken()
        ];

        return $requestData;
    }

    public function sendData($data)
    {
        return $this->sendRequest($this->endpoint, $data);
    }

    public function createResponse($response)
    {
        return new AssertResponse($this, $response);
    }
}
