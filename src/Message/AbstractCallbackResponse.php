<?php

namespace Omnipay\PlatBox\Message;

/**
 * PlatBox callback response.
 *
 * @method AbstractCallbackRequest getRequest()
 */
class AbstractCallbackResponse extends AbstractResponse
{
    /**
     * Returns the order ID.
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    /**
     * Returns the payment date.
     *
     * @return string
     */
    public function getDate()
    {
        return $this->getParameter('date');
    }

    /**
     * Returns the PlatBox transaction ID.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->getParameter('transactionId');
    }

    /**
     * Returns the currency.
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

    /**
     * Returns the amount.
     *
     * @return float
     */
    public function getAmount()
    {
        return round($this->getParameter('amount') / 100, 2);
    }

    /**
     * Returns the account ID.
     *
     * @return string
     */
    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    /**
     * @inheritdoc
     */
    public function isSuccessful()
    {
        return (boolean) $this->getParameter('platbox_id');
    }

    /**
     * Returns the callback answer for sending back.
     *
     * @return array
     */
    public function send()
    {
        $data = [];
        $data['status'] = 'ok';
        $data['merchant_tx_id'] = $this->getOrderId();
        $data['merchant_tx_extra'] = [];

        return $this->answer($data);
    }
}
