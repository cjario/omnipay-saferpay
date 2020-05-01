<?php

namespace Omnipay\Saferpay\Message;

class CaptureRequest extends AbstractRequest
{
    protected $endpoint = '/Payment/v1/Transaction/Capture';

    public function setCustomerId($customerId)
    {
        $this->setParameter('customerId', $customerId);
    }

    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    public function getTransactionId(){
        return $this->getParameter('transactionId');
    }

    public function setTransactionId($transactionId){
        $this->setParameter('transactionId', $transactionId);
    }


    public function getData()
    {
        $this->validate('transactionId', 'customerId');

        $requestData = [
            "RequestHeader" => [
                "SpecVersion" => "1.7",
                "CustomerId" => $this->getCustomerId(),
                "RequestId" => uniqid(),
                "RetryIndicator" => 0,
            ],
            "TransactionReference" => [
                "TransactionId" => $this->getTransactionId()
            ]
        ];

        return $requestData;
    }

    public function sendData($data)
    {
        return $this->sendRequest($this->endpoint, $data);
    }

    public function createResponse($response)
    {
        return new CaptureResponse($this, $response);
    }
}
