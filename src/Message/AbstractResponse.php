<?php

namespace Omnipay\PlatBox\Message;

use Omnipay\Common\Message\AbstractResponse as BaseAbstractResponse;

/**
 * PlatBox response.
 *
 * @method AbstractRequest getRequest()
 */
class AbstractResponse extends BaseAbstractResponse
{
    use SignTrait;

    /**
     * @inheritdoc
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function getCode()
    {
        return $this->getParameter('code');
    }

    /**
     * @inheritdoc
     */
    public function getMessage()
    {
        return $this->getParameter('description');
    }

    /**
     * Get a single value from response.
     *
     * @param string $key The parameter key.
     * @return mixed
     */
    protected function getParameter($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
}
