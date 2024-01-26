<?php

namespace App\Tests\Unit;

use App\Validator\ProductProviderValidator;
use PHPUnit\Framework\TestCase;

class ProductProviderValidationUnitTest extends TestCase
{
    /** @dataProvider payloadProvider */
    public function testValidatePayload(int $id, string $marketplace): void
    {
        $payload = [
            'item_id' => $id,
            'marketplace' => $marketplace,
        ];

        $validator = new ProductProviderValidator(['provider_a', 'provider_b']);
        $validatedPayload = $validator->validate($payload);

        $this->assertEquals($validatedPayload, $payload); // Just check if it wasn't mutated
    }

    public function payloadProvider(): array
    {
        return [
            [2, 'provider_a'],
            [4, 'provider_a'],
        ];
    }

}
