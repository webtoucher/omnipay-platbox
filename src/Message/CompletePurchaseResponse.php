<?php

namespace Omnipay\PlatBox\Message;

/**
 * PlatBox complete purchase response.
 */
class CompletePurchaseResponse extends AbstractCallbackResponse
{
    public function confirm()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['merchant_tx_timestamp'] = $this->getRequest()->getMerchantTxTimestamp();
        $response['merchant_tx_extra'] = $this->getRequest()->getMerchantTxExtra();
        $response['sign'] = $this->getRequest()->calculateSign($response);

        ksort($response);

        return SyncRequest::send($response, $this->getRequest());
    }
}
