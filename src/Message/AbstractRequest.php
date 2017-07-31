<?php

namespace Omnipay\PlatBox\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Omnipay\PlatBox\Exception\PlatBoxException;

/**
 * PlatBox Abstract Request
 *
 * @method self setParameter($key, $value)
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    use SignTrait;

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
     * Sets the account ID.
     *
     * @param string $value Account ID.
     * @return self
     */
    public function setAccountId($value)
    {
        return $this->setParameter('accountId', (string) $value);
    }

    /**
     * Returns the phone number.
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        if (!$phoneNumber = $this->getParameter('phoneNumber')) {
            return null;
        }
        return "+$phoneNumber";
    }

    /**
     * Sets the phone number.
     *
     * @param string $value Phone number.
     * @return self
     */
    public function setPhoneNumber($value)
    {
        return $this->setParameter('phoneNumber', str_replace([' ', '(', ')', '-', '+'], '', $value));
    }

    /**
     * Returns the endpoint.
     *
     * @return string
     */
    public function getLiveEndpoint()
    {
        return $this->getParameter('liveEndpoint');
    }

    /**
     * Sets the endpoint.
     *
     * @param string $value Endpoint.
     * @return self
     */
    public function setLiveEndpoint($value)
    {
        return $this->setParameter('liveEndpoint', $value);
    }

    /**
     * Returns the endpoint.
     *
     * @return string
     */
    public function getTestEndpoint()
    {
        return $this->getParameter('testEndpoint');
    }

    /**
     * Sets the endpoint.
     *
     * @param string $value Endpoint.
     * @return self
     */
    public function setTestEndpoint($value)
    {
        return $this->setParameter('testEndpoint', $value);
    }

    /**
     * Returns the endpoint.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->getTestEndpoint() : $this->getLiveEndpoint();
    }

    /**
     * Returns the merchant ID.
     *
     * @return string
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * Sets the merchant ID.
     *
     * @param string $value Merchant ID.
     * @return self
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * Returns the secret key.
     *
     * @return string
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * Sets the secret key.
     *
     * @param string $value Secret key.
     * @return self
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
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
     * Sets the currency.
     *
     * Available options: `RUB`.
     * Default value is `RUB`.
     *
     * @param string $value Currency.
     * @return self
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function setCurrency($value)
    {
        $value = strtoupper($value);
        if (!in_array($value, ['RUB'])) {
            throw new InvalidRequestException("'$value' is incorect currency.");
        }
        return $this->setParameter('currency', $value);
    }

    /**
     * Returns the project.
     *
     * @return string
     */
    public function getProject()
    {
        return $this->getParameter('project');
    }

    /**
     * Sets the project.
     *
     * @param string $value Project.
     * @return self
     */
    public function setProject($value)
    {
        return $this->setParameter('project', $value);
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
     * Sets the amount.
     *
     * @param float $value Amount.
     * @return self
     */
    public function setAmount($value)
    {
        return $this->setParameter('amount', (string) (integer) ($value * 100));
    }

    /**
     * Returns the order ID.
     *
     * @return string
     */
    public function getOrderId()
    {
        $order = $this->getParameter('order');

        if (is_array($order) && isset($order['order_id'])) {
            return $order['order_id'];
        }

        return null;
    }

    /**
     * Sets the order ID.
     *
     * @param string $value Order ID.
     * @return self
     */
    public function setOrderId($value)
    {
        return $this->setParameter('order', [
            'type' => 'order_id',
            'order_id' => (string) $value,
        ]);
    }

    /**
     * Returns the code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->getParameter('code');
    }

    /**
     * Sets the code.
     *
     * @param string $value Code.
     * @return self
     */
    public function setCode($value)
    {
        return $this->setParameter('code', $value);
    }
}
