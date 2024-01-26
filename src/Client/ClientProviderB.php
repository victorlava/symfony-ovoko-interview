<?php

namespace App\Client;

use App\Response\ClientProviderResponse;

class ClientProviderB extends AbstractClientProvider implements ClientProviderInterface
{
    public function getProduct(int $id): ClientProviderResponse
    {
        $body = $this->request($id, $this->dto->getUrl());

        return new ClientProviderResponse(
            $body['id'],
            $body['name'],
            $body['price'],
        );
    }
}
