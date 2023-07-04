<?php

namespace App\Service;

use App\Entity\Currencies;
use App\Repository\CurrenciesRepository;

class ApiNbpService
{
    public function __construct(private CurrenciesRepository $currenciesRepository)
    {
    }

    private function getExchangeRates(): array
    {
        $response = file_get_contents('https://api.nbp.pl/api/exchangerates/tables/A/');
        return json_decode($response, true);
    }

    public function processData(): void
    {
        $rates = $this->getExchangeRates();
        $exchangeRates = $rates[0]['rates'];

        foreach ($exchangeRates as $exchangeRate) {
            if ($exchangeRate['code'] === 'EUR') {
                $currencyName = $exchangeRate['currency'];
                $code = $exchangeRate['code'];
                $mid = $exchangeRate['mid'];

                $currency = new Currencies();
                $currency->setCurrencyName($currencyName);
                $currency->setCode($code);
                $currency->setMid($mid);

                $midFromDb = $this->currenciesRepository->findOneBy([
                    'code' => $code
                ]);

                if (isset($midFromDb)) {
                    $midFromDb->setMid($mid);
                    $this->currenciesRepository->save($midFromDb, true);
                    return;
                }

                $this->currenciesRepository->save($currency, true);
            }
        }
    }
}
