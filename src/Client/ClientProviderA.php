<?php

namespace App\Client;

use App\Response\ClientProviderResponse;

class ClientProviderA extends AbstractClientProvider implements ClientProviderInterface
{
    public function getProduct(int $id): ClientProviderResponse
    {
        $body = $this->request($id, $this->dto->getUrl());

        return new ClientProviderResponse(
            $body['id'],
            $body['productName'],
            $this->getPrice($body['productPrice']),
        );
    }

    private function getPrice(float $price): float
    {
        return $this->dto->shouldApplyConversionRate() ? $price * $this->dto->getConversionRate() : $price;
    }
}
