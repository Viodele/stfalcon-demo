<?php declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class CurrencyRateExporter
{
    public function __construct(
        #[Autowire(param: 'currencyRateProviders')]
        private array $currencyRateProviders
    ) {
    }

    public function export(string $baseCurrencyCode, array $processableCurrencies): void
    {
        foreach ($this->currencyRateProviders as $providerClass) {
            $provider = new $providerClass();
            $provider->fetchRates($baseCurrencyCode, $processableCurrencies);
        }
    }
}
