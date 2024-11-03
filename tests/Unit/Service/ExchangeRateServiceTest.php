<?php

namespace Unit\Service;

use App\Service\ExchangeRateService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class ExchangeRateServiceTest extends WebTestCase
{
    public function testGetExchangeRatesByDate()
    {
        $mockResponse = new MockResponse(json_encode([
            [
                "table" => "A",
                "no" => "234/A/NBP/2024",
                "effectiveDate" => "2024-11-03",
                "rates" => [
                    [
                        "currency" => "dolar amerykański",
                        "code" => "USD",
                        "mid" => 4.0059,
                    ],
                    [
                        "currency" => "euro",
                        "code" => "EUR",
                        "mid" => 4.353,
                    ],
                ]
            ]
        ]));

        $client = new MockHttpClient($mockResponse);
        $exchangeRateService = new ExchangeRateService($client);

        $date = '2024-11-01';
        $exchangeRates = $exchangeRateService->getExchangeRatesByDate($date);

        $this->assertCount(2, $exchangeRates);
    }

    public function testGetExchangeRatesByDateServiceError()
    {
        $mockResponse = new MockResponse(
            json_encode(['message' => 'Not Found - Brak danych']),
            ['http_code' => Response::HTTP_NOT_FOUND]
        );

        $client = new MockHttpClient($mockResponse);

        $exchangeRateService = new ExchangeRateService($client);

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('currencies not found');

        $response = $exchangeRateService->getExchangeRatesByDate('2024-11-03');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}