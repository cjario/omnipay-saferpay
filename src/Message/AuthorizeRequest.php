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

	public function setLanguage(string $language)
	{
		$this->setParameter('language', $language);
	}

	public function getLanguage()
	{
		return $this->getParameter('language');
	}

    public function getData()
    {
        $this->validate('amount', 'currency', 'transactionId', 'terminalId', 'customerId', 'returnUrl', 'description');

        $requestData = [
            "RequestHeader" => [
                "SpecVersion"    => $this->getSpec(),
                "CustomerId"     => $this->getCustomerId(),
                "RequestId"      => uniqid(),
                "RetryIndicator" => 0,
            ],
            "TerminalId"    => $this->getTerminalId(),
            "Payment"       => [
                "Amount"      => [
                    "Value"        => $this->getAmountInteger(),
                    "CurrencyCode" => $this->getCurrency(),
                ],
                "OrderId"     => $this->getTransactionId(),
                "Description" => $this->getDescription(),
            ],
            "ReturnUrl"    => [
                "Url" => $this->getReturnUrl(),
            ],
        ];

		if (!empty($this->getPaymentMethods())) {
			$requestData["PaymentMethods"] = $this->getPaymentMethods();
		}

	    if (!empty($this->getWallets())) {
		    $requestData["Wallets"] = $this->getWallets();
	    }

	    if (!empty($this->getConfigSet())) {
		    $requestData["ConfigSet"] = $this->getConfigSet();
	    }

		if ($this->getShowHolderName()) {
			$requestData['CardForm']['HolderName'] = 'MANDATORY';
		}

		$language = $this->getLanguage();
		if (!empty($language)) {
			$requestData['Payer'] = [
				'languageCode' => $language,
			];
		}

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

	public function setConfigSet(string $value)
	{
		return $this->setParameter('configSet', $value);
	}

	public function getConfigSet()
	{
		return $this->getParameter('configSet');
	}

	public function getWallets()
	{
		return $this->getParameter('wallets');
	}

	public function getPaymentMethods()
	{
		return $this->getParameter('paymentMethods');
	}

	public function setWallets(array $wallets)
	{
		return $this->setParameter('wallets', $wallets);
	}

	public function setPaymentMethods(array $paymentMethods)
	{
		return $this->setParameter('paymentMethods', $paymentMethods);
	}

	public function setShowHolderName(bool $value)
	{
		return $this->setParameter('showHolderName', $value);
	}

	public function getShowHolderName()
	{
		return (bool) $this->getParameter('showHolderName');
	}

}
