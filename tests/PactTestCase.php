<?php

declare(strict_types=1);

namespace App\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Http\GuzzleClient;
use PhpPact\Standalone\MockService\MockServer;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
use PhpPact\Standalone\MockService\Service\MockServerHttpService;
use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use PhpPact\Standalone\ProviderVerifier\Verifier;
use PhpPact\Standalone\StubService\StubServer;
use PhpPact\Standalone\StubService\StubServerConfig;
use PHPUnit\Framework\TestCase;

abstract class PactTestCase extends TestCase
{
    private MockServerEnvConfig $config;
    private MockServer $server;
    private string $pactPath;

    public function setUp(): void
    {
        parent::setUp();

        $this->config = new MockServerEnvConfig();
        $this->server = new MockServer($this->config);
        $this->server->start();

        $this->pactPath = $this->config->getPactDir() . "/client-api.json";
    }

    public function testPactVerifyAll(): void
    {
        try {
            $httpService = new MockServerHttpService(new GuzzleClient(), $this->config);
            $httpService->verifyInteractions();

            $httpService->getPactJson();
        } finally {
            $this->server->stop();
        }

        $uriProvider = new Uri('http://api');
        $uriProvider = new Uri('http://localhost:7201');
        $stubServer = $this->startSub($uriProvider);

        $config = new VerifierConfig();
        $config
            ->setProviderBaseUrl($uriProvider)
            ->setPublishResults(false);

        // Verify that the files in the array are valid.
        $verifier = new Verifier($config);
        $verifier->verifyFiles([$this->pactPath]);

        $stubServer->stop();

        // This will not be reached if the PACT verifier throws an error, otherwise it was successful.
        static::assertTrue(true, 'Pact Verification has failed.');
    }

    protected function createPact(
        string $method,
        string $endpoint,
        array $bodyRequest,
        int $responseStatus,
        array $bodyResponse = []
    ): ?array {
        $builder = new InteractionBuilder($this->config);

        $response = (new ProviderResponse())->setStatus($responseStatus);

        if (count($bodyResponse) > 0) {
            $response->addHeader('Content-Type', 'application/json');
            $response->setBody($bodyResponse);
        }

        $request = (new ConsumerRequest())
            ->setMethod($method)
            ->setPath($endpoint)
        ;

        if (count($bodyRequest) > 0) {
            $request->addHeader('Content-Type', 'application/json');
            $request->setBody($bodyRequest);
        }

        $builder
            ->uponReceiving("A {$method} request to {$endpoint}")
            ->with($request)
            ->willRespondWith($response)
        ;

        $result = $this->request($method, $endpoint, $bodyRequest);
        $builder->verify();

        return $result;
    }

    private function request(string $method, string $endpoint, array $params): ?array
    {
        $client = new Client(['base_uri' => (string) $this->config->getBaseUri()]);

        $options = ['headers' => ['Content-Type' => 'application/json']];

        if (count($params) > 0) {
            $options = array_merge($options, ['json' => $params]);
        }

        $response = $client->{$method}(new Uri($endpoint), $options);

        return json_decode($response->getBody()->getContents(), true);
    }

    private function startSub(Uri $uri): StubServer
    {
        $config = (new StubServerConfig())
            ->setPactLocation($this->pactPath)
            ->setHost($uri->getHost())
            ->setPort($uri->getPort())
        ;

        $stubServer = new StubServer($config);
        $stubServer->start();

        return $stubServer;
    }
}
