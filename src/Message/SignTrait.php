<?php

namespace Omnipay\PlatBox\Message;
use Omnipay\Common\Exception\RuntimeException;

/**
 * PlatBox callback request.
 */
trait SignTrait
{
    /**
     * Returns the data for sending back.
     *
     * @param array $data
     * @return array
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function answer($data)
    {
        ksort($data);
        $signature = $this->calculateSign($data);
        header('Content-Type: application/json');
        header("X-Signature: $signature");

        return $data;
    }

    /**
     * Calculate the sign for request or answer.
     *
     * @param $data
     * @return bool|string
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function calculateSign($data)
    {
        if ($this instanceof AbstractRequest) {
            $secretKey = $this->getSecretKey();
        } elseif ($this instanceof AbstractResponse) {
            $secretKey = $this->getRequest()->getSecretKey();
        } else {
            throw new RuntimeException('Wrong using of the trait.');
        }
        return hash_hmac('SHA256', is_array($data) ? json_encode($data) : $data, $secretKey);
    }
}
