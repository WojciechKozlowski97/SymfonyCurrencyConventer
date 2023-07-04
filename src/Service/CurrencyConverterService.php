<?php

namespace App\Service;

use App\Repository\CurrenciesRepository;

class CurrencyConverterService
{
    public function __construct(private CurrenciesRepository $currenciesRepository)
    {
    }

    public function calculate($amount): float
    {
        $eurObject = $this->currenciesRepository->findOneBy([
            'code' => 'EUR'
        ]);

        $eurMid = $eurObject->getMid();

        return $amount * $eurMid;
    }
}
