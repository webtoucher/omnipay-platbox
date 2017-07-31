<?php

namespace Omnipay\PlatBox;

use Guzzle\Http\Client as HttpClient;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Exception\RuntimeException;
use Omnipay\PlatBox\Message\AbstractRequest;
use Omnipay\PlatBox\Message\CheckRequest;
use Omnipay\PlatBox\Message\CompletePurchaseRequest;
use Omnipay\PlatBox\Message\PurchaseRequest;

/**
 * Gateway for PlatBox
 * https://platbox.com/new/docs/paybox_api_1.pdf
 *
 * @method AbstractRequest createRequest($class, array $parameters)
 */
class Gateway extends AbstractGateway
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'PlatBox';
    }

    /**
     * @inheritdoc
     */
    public function getDefaultParameters()
    {
        return [
            'currency' => 'RUB',
            'liveEndpoint' => 'https://paybox-global2.platbox.com/merchant/mobile',
            'testEndpoint' => 'https://playground.platbox.com/merchant/mobile',
            'testMode' => false,
        ];
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
     * @inheritdoc
     * @return PurchaseRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $options = [])
    {
        return $this->createRequest('\Omnipay\PlatBox\Message\PurchaseRequest', $options);
    }

    /**
     * @param array $options
     *
     * @return CheckRequest|\Omnipay\Common\Message\AbstractRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function check(array $options = [])
    {
        if (!$options) {
            throw new RuntimeException('Options is required for request initialization');
        }
        if (!isset($options['received_sign'], $options['data_raw'])) {
            throw new RuntimeException('The raw data and the received signature is required');
        }
        return $this->createRequest('\Omnipay\PlatBox\Message\CheckRequest', $options);
    }

    /**
     * @inheritdoc
     * @return CompletePurchaseRequest|\Omnipay\Common\Message\AbstractRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function completePurchase(array $options = [])
    {
        if (!$options) {
            throw new RuntimeException('Options is required for request initialization');
        }
        if (!isset($options['received_sign'], $options['data_raw'])) {
            throw new RuntimeException('The raw data and the received signature is required');
        }
        return $this->createRequest('\Omnipay\PlatBox\Message\CompletePurchaseRequest', $options);
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultHttpClient()
    {
        return new HttpClient('', [
            HttpClient::CURL_OPTIONS => [
                CURLOPT_CONNECTTIMEOUT => 60,
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_RETURNTRANSFER => true,
            ],
            HttpClient::REQUEST_OPTIONS => [
                'headers' => [
                    'Cache-Control' => 'no-cache',
                ],
            ],
        ]);
    }
}
