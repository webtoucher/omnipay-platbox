<?php

namespace Omnipay\PlatBox\Message;

/**
 * PlatBox purchase request.
 */
class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('merchantId', 'accountId', 'phoneNumber', 'amount', 'currency', 'order', 'project');

        $data = [];
        $data['merchant_id'] = $this->getParameter('merchantId');
        $data['account'] = [
            'id' => $this->getParameter('accountId')
        ];
        $data['payer'] = [
            'phone_number' => $this->getParameter('phoneNumber')
        ];
        $data['amount'] = $this->getParameter('amount');
        $data['currency'] = $this->getParameter('currency');
        $data['order'] = $this->getParameter('order');
        $data['project'] = $this->getParameter('project');

        return $data;
    }

    /**
     * @inheritdoc
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function sendData($data)
    {
        ksort($data);
        $url = $this->getEndpoint();
        $headers = [
            'X-Signature' => $this->calculateSign($data),
            'Content-Type' => 'application/json',
        ];
        $httpRequest = $this->httpClient->post($url, $headers, json_encode($data));
        $httpResponse = $httpRequest->send();
        $result = $httpResponse->getStatusCode() === 200 ? json_decode($httpResponse->getBody(true), true) : [];

        return $this->response = new PurchaseResponse($this, $result);
    }
}
