<?php

namespace App\Factory;

use App\Client\ClientProviderA;
use App\Client\ClientProviderB;
use App\Client\ClientProviderInterface;
use App\Dto\ClientProviderDto;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientProviderFactory
{
    private array $registry = [
        'provider_a' => [
            'namespace' => ClientProviderA::class,
            'url' => 'http://api1mock:8080/products/%s', // TODO: take from env. or use symfony autowiring parameters
        ],
        'provider_b' => [
            'namespace' => ClientProviderB::class,
            'url' => 'http://api2mock:8080/get_product?id=%s',
            'conversionRate' => 1.2
        ]
    ];

    public function __construct(private HttpClientInterface $client)
    {
    }

    public function create(string $marketplace): ClientProviderInterface
    {
        try {
            if (isset($this->registry[$marketplace])) {
                $settings = new ClientProviderDto($this->registry[$marketplace]);

                return new $this->registry[$marketplace]['namespace']($this->client, $settings);
            }
        } catch(\Exception) {
            throw new \Exception(sprintf('Marketplace %s not found in the registry or failed to initialize', $marketplace));
        }
    }
}
