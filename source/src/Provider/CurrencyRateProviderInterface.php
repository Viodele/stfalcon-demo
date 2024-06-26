<?php declare(strict_types=1);

namespace App\Provider;

interface CurrencyRateProviderInterface
{
    public function fetchRates(string $baseCurrencyCode, array $currencyCodes): array;
}
