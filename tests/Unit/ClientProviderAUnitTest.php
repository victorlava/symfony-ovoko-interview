<?php

namespace App\Tests\Integration;

use App\Client\ClientProviderA;
use App\Dto\ClientProviderDto;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class ClientProviderAUnitTest extends TestCase
{
    public function testGetProduct()
    {
        $expected['id'] = 123;
        $expected['name'] = 'test';
        $expected['conversionRate'] = 2;
        $expected['initialPrice'] = 20;
        $expected['finalPrice'] = $expected['initialPrice'] * $expected['conversionRate'];
        $expected['url'] = 'https://localhost/products/%s';
        $expected['response'] = [
            'id' => $expected['id'],
            'productName' => $expected['name'],
            'productPrice' => $expected['initialPrice']
        ];

        $settings = new ClientProviderDto(
            [
                'url' => $expected['url'],
                'conversionRate' => $expected['conversionRate'],
            ]
        );
        $mockResponse = new MockResponse(json_encode($expected['response']));
        $provider = new ClientProviderA(new MockHttpClient($mockResponse), $settings);
        $response = $provider->getProduct($expected['id']);

        $this->assertEquals(sprintf($expected['url'], $expected['id']), $mockResponse->getRequestUrl());
        $this->assertEquals(
            [
                'id' => $expected['id'],
                'name' => $expected['name'],
                'price' => [
                    'amount' => $expected['finalPrice'],
                    'currency' => 'USD',
                ]
            ], $response->toArray());
    }
}
