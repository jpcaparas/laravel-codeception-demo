<?php
namespace App\Contracts;

use App\Packages\StripeApiClient\Config\ApiClientConfig;
use Stripe\HttpClient\ClientInterface;
use Stripe\StripeObject;

interface StripeApiClient
{
    public function setConfig(ApiClientConfig $config): StripeApiClient;

    public function getConfig(): ApiClientConfig;

    public function setHttpClient(ClientInterface $client): StripeApiClient;

    public function getExchangeRate(string $currency): StripeObject;
}
