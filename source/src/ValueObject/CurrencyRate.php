<?php declare(strict_types=1);

namespace App\ValueObject;

final class CurrencyRate
{
    private string $currency;
    private float $rateBuy;
    private float $rateSell;
    private string $provider;

    public function setCurrency(string $currency): CurrencyRate
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setRateBuy(float $rateBuy): CurrencyRate
    {
        $this->rateBuy = $rateBuy;

        return $this;
    }

    public function getRateBuy(): float
    {
        return $this->rateBuy;
    }

    public function setRateSell(float $rateSell): CurrencyRate
    {
        $this->rateSell = $rateSell;

        return $this;
    }

    public function getRateSell(): float
    {
        return $this->rateSell;
    }

    public function setProvider(string $provider): CurrencyRate
    {
        $this->provider = $provider;

        return $this;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }
}
