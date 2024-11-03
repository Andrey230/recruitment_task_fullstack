<?php

namespace App\Service;

use App\DTO\ExchangeRateDTO;
use App\Model\ExchangeRate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExchangeRateService
{
    private $baseUri = 'https://api.nbp.pl/api/';

    private $allowCurrencies = [
        'EUR',
        'USD',
        'CZK',
        'IDR',
        'BRL',
    ];


    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Retrieves and returns exchange rates for a specified date.
     *
     * @return ExchangeRateDTO[]
     * @throws NotFoundHttpException if exchange rates are not found
     */
    public function getExchangeRatesByDate(string $date): array
    {
        try {
            $response = $this->httpClient->request('GET', $this->baseUri."exchangerates/tables/a/{$date}?format=json");
            $responseData = $response->toArray();

            return $this->getExchangeRatesDTO($responseData);
        }catch (\Exception $exception){
            throw new NotFoundHttpException('currencies not found');
        }
    }

    /** @return ExchangeRateDTO[] */
    private function getExchangeRatesDTO(array $responseData): array
    {
        $exchangeRates = [];

        foreach ($responseData[0]['rates'] as $currency){
            if(in_array($currency['code'], $this->allowCurrencies)){
                $exchangeRate = new ExchangeRate(
                    $currency['code'],
                    $currency['currency'],
                    $currency['mid']
                );

                $exchangeRates[] = $exchangeRate->convertToDTO();
            }
        }

        return $exchangeRates;
    }
}