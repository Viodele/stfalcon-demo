<?php declare(strict_types=1);

namespace App\Provider\Monobank\DTO;

final class MonobankRate
{
    private int $currencyCodeA;
    private int $currencyCodeB;
    private int $date;
    private ?float $rateBuy = null;
    private ?float $rateSell = null;
    private ?float $rateCross = null;

    public function setCurrencyCodeA(int $currencyCodeA): MonobankRate
    {
        $this->currencyCodeA = $currencyCodeA;

        return $this;
    }

    public function getCurrencyCodeA(): int
    {
        return $this->currencyCodeA;
    }

    public function setCurrencyCodeB(int $currencyCodeB): MonobankRate
    {
        $this->currencyCodeB = $currencyCodeB;

        return $this;
    }

    public function getCurrencyCodeB(): int
    {
        return $this->currencyCodeB;
    }

    public function setDate(int $date): MonobankRate
    {
        $this->date = $date;

        return $this;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function setRateBuy(?float $rateBuy): MonobankRate
    {
        $this->rateBuy = $rateBuy;

        return $this;
    }

    public function getRateBuy(): ?float
    {
        return $this->rateBuy;
    }

    public function setRateSell(?float $rateSell): MonobankRate
    {
        $this->rateSell = $rateSell;

        return $this;
    }

    public function getRateSell(): ?float
    {
        return $this->rateSell;
    }

    public function setRateCross(?float $rateCross): MonobankRate
    {
        $this->rateCross = $rateCross;

        return $this;
    }

    public function getRateCross(): ?float
    {
        return $this->rateCross;
    }
}
