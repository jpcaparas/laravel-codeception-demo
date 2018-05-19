<?php

namespace Tests\Feature;

use App\Contracts\StripeApiClient;
use App\Packages\StripeApiClient\Config\ApiClientConfig;
use Mockery\CompositeExpectation;
use Mockery\MockInterface;
use Stripe\ApiRequestor;
use Stripe\HttpClient\ClientInterface;
use Stripe\Stripe;
use Tests\TestCase;

class StripeApiClientTest extends TestCase
{
    /**
     * @var StripeApiClient
     */
    private $apiClient;

    /**
     * @var MockInterface|ClientInterface
     */
    private $httpClientMock;

    protected function setUp()
    {
        parent::setUp();

        $this->httpClientMock = \Mockery::mock(ClientInterface::class);

        $config = new ApiClientConfig();
        $config->setApiKey('test');
        $this->apiClient = app(StripeApiClient::class);

        $this->apiClient
            ->setConfig($config)
            ->setHttpClient($this->httpClientMock);
    }

    protected function tearDown()
    {
        parent::tearDown();

        \Mockery::close();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCurrencyExchange()
    {
        $this->stubRequest(
            'get',
            '/v1/exchange_rates/usd',
            [],
            [],
            false,
            [
                'id' => 'usd',
                'object' => 'exchange_rate',
                'rates' => ['eur' => 0.845876],
            ]
        );

        $rates = $this->apiClient->getExchangeRate('usd');

        $this->assertEquals('exchange_rate', $rates->object);
    }

    protected function stubRequest(
        string $method,
        string $path,
        array $headers = [],
        array $params = [],
        bool $hasFile = false,
        array $response = [],
        int $returnCode = 200,
        $base = null
    )
    {
        $this->prepareRequestMock()->andReturns([json_encode($response), $returnCode, []]);

        $baseUrl = ($base ?? Stripe::$apiBase) . $path;

        return $this->httpClientMock->request($method, $baseUrl, $headers, $params, $hasFile);
    }

    private function prepareRequestMock(): CompositeExpectation
    {
        ApiRequestor::setHttpClient($this->httpClientMock);

        return $this->httpClientMock
            ->shouldReceive('request')
            ->atLeast()->once()
            ->withArgs(function(...$args) {
               [$method, $path, $headers, $params, $hasFile] = $args;

               if (!is_string($method)) {
                   return false;
               }

               if (!is_string($method)) {
                   return false;
               }

               if (!is_string($path)) {
                   return false;
               }

               if (!is_array($headers)) {
                   return false;
               }

                if (!is_array($params)) {
                    return false;
                }

                if (!is_bool($hasFile)) {
                   return false;
                }

               return true;
            });
    }
}
