<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ExchangeRateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ExchangeRatesController extends AbstractController
{
    private $exchangeRateService;

    public function __construct(
        ExchangeRateService $exchangeRateService
    )
    {
        $this->exchangeRateService = $exchangeRateService;
    }

    public function getExchangeRatesByDate(string $date): JsonResponse
    {
        try {
            $result = $this->exchangeRateService->getExchangeRatesByDate($date);
            return $this->json($result);
        }catch (\Exception $exception){
            return $this->json([
                'error' => $exception->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
