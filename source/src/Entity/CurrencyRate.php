<?php declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;

class CurrencyRate
{
    private int $id;
    private string $currencyTo;
    private float $rateBuy;
    private float $rateSell;
    private DateTimeImmutable $updatedAt;
}
