<?php

namespace App\Model;

use App\DTO\ExchangeRateDTO;

class ExchangeRate
{
    const BUY_RATE_CURRENCIES = ['EUR', 'USD'];
    const EXTRA_FEE_CURRENCIES = [
        'amount' => 0.08,
        'exceptCurrencies' => ['EUR', 'USD'],
    ];

    private $currencyCode;
    private $currencyName;
    private $nbpRate;

    public function __construct(
        string $currencyCode,
        string $currencyName,
        float $nbpRate
    )
    {
        $this->currencyCode = $currencyCode;
        $this->currencyName = $currencyName;
        $this->nbpRate = $nbpRate;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function getCurrencyName(): string
    {
        return $this->currencyName;
    }

    public function getNbpRate(): float
    {
        return $this->nbpRate;
    }

    public function getBuyRate(): ?float
    {
        if (in_array($this->currencyCode, self::BUY_RATE_CURRENCIES)) {
            return $this->nbpRate - 0.05;
        }
        return null;
    }

    public function getSellRate(): float
    {
        return $this->nbpRate + 0.07 + (
            !in_array($this->currencyCode, self::EXTRA_FEE_CURRENCIES['exceptCurrencies'])
                ? self::EXTRA_FEE_CURRENCIES['amount']
                : 0
            );
    }

    public function convertToDTO(): ExchangeRateDTO
    {
        return new ExchangeRateDTO(
            $this->getCurrencyCode(),
            $this->getCurrencyName(),
            $this->getNbpRate(),
            $this->getBuyRate(),
            $this->getSellRate()
        );
    }
}