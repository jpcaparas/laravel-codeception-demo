<?php
namespace App\Packages\StripeApiClient\Config;

use Stripe\HttpClient\ClientInterface;
use Stripe\HttpClient\CurlClient;
use Stripe\Stripe;

/**
 *
 * @see \Stripe\TestCase
 */
class ApiClientConfig
{
    /** @var ClientInterface */
    private $httpClient;

    /**
     * @return string
     */
    public function getApiBase(): string
    {
        return Stripe::$apiBase;
    }

    /**
     * @param string $apiBase
     */
    public function setApiBase(string $apiBase): ApiClientConfig
    {
        Stripe::$apiBase = $apiBase;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return Stripe::getApiKey();
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey): ApiClientConfig
    {
        Stripe::setApiKey($apiKey);

        return $this;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return Stripe::getClientId();
    }

    /**
     * @param string $clientId
     */
    public function setClientId(string $clientId): ApiClientConfig
    {
        $this->setClientId($clientId);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getApiVersion()
    {
        return Stripe::$apiVersion;
    }

    /**
     * @param mixed $apiVersion
     */
    public function setApiVersion($apiVersion): ApiClientConfig
    {
        Stripe::$apiVersion = $apiVersion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return Stripe::getAccountId();
    }

    /**
     * @param mixed $accountId
     */
    public function setAccountId($accountId): ApiClientConfig
    {
        Stripe::setAccountId($accountId);

        return $this;
    }

    /**
     * @return ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient ?? CurlClient::instance();
    }

    /**
     * @param ClientInterface $httpClient
     */
    public function setHttpClient(ClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;
    }
}