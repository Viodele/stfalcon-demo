<?php declare(strict_types=1);

namespace App\Provider\PrivatBank\DTO;

final class PrivatBankRate
{
    private string $ccy;
    private string $baseCcy;
    private string $buy;
    private string $sale;

    public function setCcy(string $ccy): PrivatBankRate
    {
        $this->ccy = $ccy;

        return $this;
    }

    public function getCcy(): string
    {
        return $this->ccy;
    }

    public function setBaseCcy(string $baseCcy): PrivatBankRate
    {
        $this->baseCcy = $baseCcy;

        return $this;
    }

    public function getBaseCcy(): string
    {
        return $this->baseCcy;
    }

    public function setBuy(string $buy): PrivatBankRate
    {
        $this->buy = $buy;

        return $this;
    }

    public function getBuy(): float
    {
        return floatval($this->buy);
    }

    public function setSale(string $sale): PrivatBankRate
    {
        $this->sale = $sale;

        return $this;
    }

    public function getSale(): float
    {
        return floatval($this->sale);
    }
}
