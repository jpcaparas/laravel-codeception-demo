<?php
namespace App\Packages\StripeApiClient;

use App\Contracts\StripeApiClient as Contract;
use App\Packages\StripeApiClient\Config\ApiClientConfig;
use Stripe\ApiRequestor;
use Stripe\ExchangeRate;
use Stripe\HttpClient\ClientInterface;
use Stripe\StripeObject;

class StripeApiClient implements Contract
{
    /**
     * @var ApiClientConfig
     */
    private $config;

    public function getExchangeRate(string $currency): StripeObject
    {
        return ExchangeRate::retrieve($currency);
    }

    public function setConfig(ApiClientConfig $config): Contract
    {
        $this->config = $config;

        return $this;
    }

    public function getConfig(): ApiClientConfig
    {
        return $this->config;
    }

    public function setHttpClient(ClientInterface $client): Contract
    {
        $this->config->setHttpClient($client);

        return $this;
    }
}
