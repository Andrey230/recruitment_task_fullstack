<?php

namespace App\DTO;

class ExchangeRateDTO
{
    public $currencyCode;
    public $currencyName;
    public $nbpRate;
    public $buyRate;
    public $sellRate;

    public function __construct(
        string $currencyCode,
        string $currencyName,
        float $nbpRate,
        ?float $buyRate,
        float $sellRate
    )
    {
        $this->currencyCode = $currencyCode;
        $this->currencyName = $currencyName;
        $this->nbpRate = $nbpRate;
        $this->buyRate = $buyRate;
        $this->sellRate = $sellRate;
    }
}