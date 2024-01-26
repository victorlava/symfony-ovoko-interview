<?php

namespace App\Factory;

use App\Client\ClientProviderInterface;
use App\Dto\ClientProviderDto;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientProviderFactory
{
    public function __construct(
        private HttpClientInterface $client,
        private array $providers,
    )
    {
    }

    public function create(string $marketplace): ClientProviderInterface
    {
        try {
            if (isset($this->providers[$marketplace])) {
                return new $this->providers[$marketplace]['service'](
                    $this->client,
                    new ClientProviderDto($this->providers[$marketplace])
                );
            }
        } catch(\Exception $e) {
            throw new \Exception(
                sprintf('Marketplace %s not found in the registry or failed to initialize', $marketplace, $e
                )
            );
        }
    }
}
