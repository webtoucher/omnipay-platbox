<?php

namespace Omnipay\PlatBox\Message;

/**
 * PlatBox initPayment response.
 */
class PurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return isset($this->data['platbox_id']);
    }
}
