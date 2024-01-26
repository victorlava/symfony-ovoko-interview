<?php

namespace App\Response;

class ClientProviderResponse
{
    public function __construct(
        private int $id,
        private string $name,
        private float $price
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => [
                'amount' => $this->price,
                'currency' => 'USD',
            ],
        ];
    }
}
