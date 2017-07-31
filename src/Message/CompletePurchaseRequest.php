<?php

namespace Omnipay\PlatBox\Message;

/**
 * PlatBox complete purchase request.
 *
 * @method CompletePurchaseResponse send()
 */
class CompletePurchaseRequest extends AbstractCallbackRequest
{
    /**
     * @param mixed $data
     *
     * @return CompletePurchaseResponse
     * @throws \Omnipay\Common\Exception\InvalidResponseException
     */
    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
