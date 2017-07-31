<?php

namespace Omnipay\PlatBox\Message;

use Omnipay\PlatBox\Exception\PlatBoxException;

/**
 * PlatBox callback request.
 */
abstract class AbstractCallbackRequest extends AbstractRequest
{
    /**
     * @var string
     */
    public $receivedSign;

    /**
     * @var string
     */
    public $calculatedSign;

    /**
     * @var string
     */
    public $d;

    /**
     * Sets the PlatBox transaction ID.
     *
     * @param string $value Transaction ID.
     * @return self
     */
    public function setPlatboxTxId($value)
    {
        return $this->setParameter('transactionId', $value);
    }

    /**
     * Sets the PlatBox transaction date.
     *
     * @param string $value Transaction date.
     * @return self
     */
    public function setPlatboxTxCreatedAt($value)
    {
        return $this->setParameter('date', $value);
    }

    /**
     * Sets the PlatBox transaction info.
     *
     * @param array $value Transaction info.
     * @return self
     */
    public function setPayment($value)
    {
        return $this->setParameter('payment', $value);
    }

    /**
     * Sets the PlatBox transaction account info.
     *
     * @param array $value Transaction account info.
     * @return self
     */
    public function setAccount($value)
    {
        return $this->setParameter('account', $value);
    }

    /**
     * Sets the PlatBox transaction order info.
     *
     * @param array $value Transaction order info.
     * @return self
     */
    public function setOrder($value)
    {
        return $this->setParameter('order', $value);
    }

    /**
     * @param string $value
     * @return self
     */
    public function setDataRaw($value)
    {
        return $this->setParameter('dataRaw', $value);
    }

    /**
     * @param string $value
     * @return self
     */
    public function setReceivedSign($value)
    {
        return $this->setParameter('receivedSign', $value);
    }

    public function getData()
    {
        $this->validate('transactionId', 'date', 'payment', 'account', 'order');

        $receivedSign = $this->getParameter('receivedSign');
        $calculatedSign = $this->calculateSign($this->getParameter('dataRaw'));
        if ($receivedSign !== $calculatedSign) {
            PlatBoxException::throwException(PlatBoxException::CODE_INCORRECT_SIGNATURE_REQUEST, "Ожидается '$calculatedSign', получено '$receivedSign'");
        }

        $data = [];
        $data['transactionId'] = $this->getParameter('transactionId');
        $data['date'] = $this->getParameter('date');
        $data['amount'] = $this->getParameter('payment')['amount'];
        $data['currency'] = $this->getParameter('payment')['currency'];
        $data['account'] = $this->getParameter('account')['id'];
        $data['orderId'] = $this->getParameter('order')['order_id'];

        return $data;
    }

    /**
     * Returns the callback error for sending back.
     *
     * @param string $message
     * @param int $code
     * @return array
     */
    public function error($message = 'Unknown error', $code = 0)
    {
        $data = [];
        $data['status'] = 'error';
        $data['code'] = $code;
        $data['description'] = $message;

        return $this->answer($data);
    }
}
