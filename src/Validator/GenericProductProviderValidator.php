<?php

namespace App\Validator;

use App\Exception\ValidationException;

class GenericProductProviderValidator
{
    public function __construct(
        private array $providers = []
    )
    {
        $this->providers = ['provider_a', 'provider_b']; //TODO: temporary
    }

    public function validate(array $data): array
    {
        $errorBag = [];

        if (!isset($data['marketplace']) || !in_array($data['marketplace'], $this->providers)) {
            $errorBag[] = 'Correct marketplace id should be set';
        }

        if (!isset($data['item_id']) || !is_numeric($data['item_id'])) {
            $errorBag[] = 'Item ID should be set and be numeric';
        }

        if ($errorBag !== []) {
             throw new ValidationException($errorBag);
        }

        return $data;
    }
}
