<?php

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ProductControllerIntegrationTest extends WebTestCase
{
    /** @dataProvider correctMarketplaceProvider */
    public function testWhenGettingSingleProductReturns200(int $id, string $marketplace): void
    {
        static::createClient()->request(
            Request::METHOD_GET,
            sprintf('/products/%d?filter[marketplace]=%s', $id, $marketplace),
        );

        $this->assertResponseIsSuccessful();
    }

    /** @dataProvider brokenRequestProvider */
    public function testWhenProductIsNotFoundReturn404(mixed $id, mixed $marketplace): void
    {
        static::createClient()->request(
            Request::METHOD_GET,
            sprintf('/products/%d?filter[marketplace]=%s', $id, $marketplace),
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    /** @dataProvider notFoundMarketplaceProvider */
    public function testWhenSendingWrongRequestReturns400(mixed $id, mixed $marketplace): void
    {
        static::createClient()->request(
            Request::METHOD_GET,
            sprintf('/products/%d?filter[marketplace]=%s', $id, $marketplace),
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function correctMarketplaceProvider(): array
    {
        return [
            [1, 'provider_a'],
            [2, 'provider_b'],
        ];
    }

    public function notFoundMarketplaceProvider(): array
    {
        return [
            [123, 'provider_a'],
            [521, 'provider_b'],
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
