<?php

/**
 * Tests for the Stripe API client
 *
 * @see https://stripe.com/docs/api
 */
class StripeApiClientTest extends \Codeception\Test\Unit
{
    /** @var Stripe\HttpClient\ClientInterface|\Mockery\MockInterface */
    private $clientMock;

    protected function _before()
    {
        $this->setupClientMock();
    }

    protected function _after()
    {
        Mockery::close();
    }

    public function testCanList()
    {
        $response = $this->stubRequest(
            'GET',
            '/things',
            [],
            [],
            false,
            [
                'data' => [['id' => 1]],
                'has_more' => true,
                'url' => '/things',
            ]
        );

        [$data] = $response;

        $this->assertArraySubset([
            'data' => [['id' => 1]],
            'has_more' => true,
            'url' => '/things',
        ], json_decode($data, ARRAY_FILTER_USE_KEY));
    }

    protected function setupClientMock(): void
    {
        /**
         * @var \Stripe\HttpClient\ClientInterface|\Mockery\Mock $stripeClientMock
         */
        $this->clientMock = Mockery::mock(\Stripe\HttpClient\ClientInterface::class);
    }

    /**
     * Stubs an API request
     */
    protected function stubRequest(
        string $method,
        string $path,
        array $headers = [],
        array $params = [],
        bool $hasFile = false,
        array $response = [],
        int $returnCode = 200,
        $base = null
    ): array
    {
        \Stripe\ApiRequestor::setHttpClient($this->clientMock);

        if (is_null($base)) {
            $base = \Stripe\Stripe::$apiBase;
        }

        $absUrl = $base . $path;

        $this->clientMock
            ->shouldReceive('request')
            ->once()
            ->with(
                $method,
                $absUrl,
                $headers,
                $params,
                $hasFile
            )
            ->andReturns([
                json_encode($response),
                $returnCode
            ]);

        return $this->clientMock->request($method, $absUrl, $headers, $params, $hasFile);
    }
}