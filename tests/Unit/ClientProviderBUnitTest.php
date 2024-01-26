<?php

namespace App\Tests\Unit;

use App\Client\ClientProviderB;
use App\Dto\ClientProviderDto;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class ClientProviderBUnitTest extends TestCase
{
    public function testGetProduct(): void
    {
        $expected['id'] = 123;
        $expected['name'] = 'test';
        $expected['price'] = 20;
        $expected['url'] = 'https://localhost/products/%s';
        $expected['response'] = [
            'id' => $expected['id'],
            'name' => $expected['name'],
            'price' => $expected['price']
        ];

        $settings = new ClientProviderDto(
            [
                'url' => $expected['url'],
            ]
        );
        $mockResponse = new MockResponse(json_encode($expected['response']));
        $provider = new ClientProviderB(new MockHttpClient($mockResponse), $settings);
        $response = $provider->getProduct($expected['id']);

        $this->assertEquals(sprintf($expected['url'], $expected['id']), $mockResponse->getRequestUrl());
        $this->assertEquals(
            [
                'id' => $expected['id'],
                'name' => $expected['name'],
                'price' => [
                    'amount' => $expected['price'],
                    'currency' => 'USD',
                ]
            ], $response->toArray());
    }
}
