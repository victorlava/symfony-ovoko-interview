<?php

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerIntegrationTest extends WebTestCase
{

    /** @dataProvider correctMarketplaceProvider */
    public function testWhenGettingSingleProductReturns200(int $id, string $marketplace): void
    {
        $client = static::createClient();

        $client->request(
            'GET',
            sprintf('/products/%d?filter[marketplace]=%s', $id, $marketplace),
        );

        $this->assertResponseIsSuccessful();
    }

    /** @dataProvider brokenRequestProvider */
    public function testWhenSendingWrongRequestReturns400(mixed $id, mixed $marketplace): void
    {
        $client = static::createClient();

        $client->request(
            'GET',
            sprintf('/products/%d?filter[marketplace]=%s', $id, $marketplace),
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function correctMarketplaceProvider(): array
    {
        return [
            [5, 'provider_a'],
            [10, 'provider_b'],
        ];
    }

    public function brokenRequestProvider(): array
    {
        return [
            [2, 'provider12'],
            [5, 'pro'],
            ['integer', 'provider_a'],
            [4, 5],
        ];
    }
}
