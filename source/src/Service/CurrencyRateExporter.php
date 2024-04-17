<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\CurrencyRate;
use App\Repository\CurrencyRateRepository;
use App\ValueObject\CurrencyRate as CurrencyRateValueObject;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

final readonly class CurrencyRateExporter
{
    public function __construct(
        private CurrencyRateRepository $currencyRateRepository,
        private Notifier $notifier,
        #[Autowire(param: 'currencyRateProviders')]
        private array $currencyRateProviders,
        #[Autowire(param: 'currencyRateChangeThreshold')]
        private ?float $rateChangeThreshold = null
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function export(string $baseCurrencyCode, array $processableCurrencies): void
    {
        foreach ($this->currencyRateProviders as $providerClass) {
            $provider = new $providerClass();
            $this->updateLocalCurrencyRates($provider->fetchRates($baseCurrencyCode, $processableCurrencies));
        }
        $this->notifier->flush();
    }

    /**
     * @param CurrencyRateValueObject[] $currencyRates
     */
    private function updateLocalCurrencyRates(array $currencyRates): void
    {
        foreach ($currencyRates as $currencyRate) {
            $this->checkoutCurrencyRates($currencyRate);
        }
    }

    private function checkoutCurrencyRates(CurrencyRateValueObject $currencyRateValues): void
    {
        $currencyRate = $this->currencyRateRepository->findOneBy([
            'provider' => $currencyRateValues->getProvider(),
            'currency' => $currencyRateValues->getCurrency(),
        ]);

        if (false === $currencyRate instanceof CurrencyRate) {
            $currencyRate = new CurrencyRate();
            $this->notifier->push(sprintf(
                'Exchange rates for \'%s\' at \'%s\' set for the first time: buy - %.6g, sell - %.6g.',
                $currencyRateValues->getCurrency(),
                $currencyRateValues->getProvider(),
                $currencyRateValues->getRateBuy(),
                $currencyRateValues->getRateSell()
            ));
        } elseif (
            $this->rateChangeThreshold <= abs($currencyRateValues->getRateBuy() - $currencyRate->getBuy())
            || $this->rateChangeThreshold <= abs($currencyRateValues->getRateSell() - $currencyRate->getSell())
        ) {
            $this->notifier->push(sprintf(
                'Extreme rate change for \'%s\' at \'%s\' detected: buy - %.6g(%+.6g), sell - %.6g(%+.6g).',
                $currencyRateValues->getCurrency(),
                $currencyRateValues->getProvider(),
                $currencyRateValues->getRateBuy(),
                $currencyRateValues->getRateBuy() - $currencyRate->getBuy(),
                $currencyRateValues->getRateSell(),
                $currencyRateValues->getRateSell() - $currencyRate->getSell()
            ));
        }

        $currencyRate->setProvider($currencyRateValues->getProvider())
            ->setCurrency($currencyRateValues->getCurrency())
            ->setBuy($currencyRateValues->getRateBuy())
            ->setSell($currencyRateValues->getRateSell());
        $this->currencyRateRepository->save($currencyRate);
    }
}
