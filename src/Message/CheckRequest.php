<?php

namespace Omnipay\PlatBox\Message;

/**
 * PlatBox check request.
 *
 * @method CheckResponse send()
 */
class CheckRequest extends AbstractCallbackRequest
{
    /**
     * @param mixed $data
     *
     * @return CheckResponse
     * @throws \Omnipay\Common\Exception\InvalidResponseException
     */
    public function sendData($data)
    {
        return $this->response = new CheckResponse($this, $data);
    }
}
