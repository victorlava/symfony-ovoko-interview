<?php

namespace App\Validator;

use App\Exception\ValidationException;

class ProductProviderValidator
{
    public function __construct(
        private array $providers = []
    )
    {
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
