<?php

namespace Omnipay\Saferpay\Message;

class AuthorizeRequest extends AbstractRequest
{
    protected $endpoint = '/Payment/v1/PaymentPage/Initialize';

    public function setTerminalId($terminalId)
    {
        $this->setParameter('terminalId', $terminalId);
    }

    public function getTerminalId()
    {
        return $this->getParameter('terminalId');
    }

    public function setCustomerId($customerId)
    {
        $this->setParameter('customerId', $customerId);
    }

    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    public function setDescription($description)
    {
        $this->setParameter('description', $description);
    }
    public function getDescription()
    {
        return $this->getParameter('description');
    }

    public function getData()
    {
        $this->validate('amount', 'currency', 'transactionId', 'terminalId', 'customerId', 'returnUrl', 'cancelUrl');

        $requestData = [
            "RequestHeader" => [
                "SpecVersion" => "1.7",
                "CustomerId" => $this->getCustomerId(),
                "RequestId" => uniqid(),
                "RetryIndicator" => 0,
            ],
            "TerminalId" => $this->getTerminalId(),
            "Payment" => [
                "Amount" => [
                    "Value" => $this->getAmountInteger(),
                    "CurrencyCode" => $this->getCurrency(),
                ],
                "OrderId" => $this->getTransactionId(),
                "Description" => $this->getDescription(),
            ],
            "ReturnUrls" => [
                "Success" => $this->getReturnUrl(),
                "Fail" => $this->getCancelUrl(),
            ],
        ];

        return $requestData;
    }

    public function sendData($data)
    {
        return $this->sendRequest($this->endpoint, $data);
    }

    public function createResponse($response)
    {
        return new AuthorizeResponse($this, $response);
    }
}
