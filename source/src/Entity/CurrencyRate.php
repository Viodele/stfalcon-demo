<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\CurrencyRateRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'currency_rate')]
#[ORM\Entity(repositoryClass: CurrencyRateRepository::class)]
#[ORM\UniqueConstraint(name: 'idx_provider_currency', columns: ['provider', 'currency'])]
class CurrencyRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int|null $id = null;

    #[ORM\Column(type: Types::STRING, length: 63)]
    private string $provider;

    #[ORM\Column(type: Types::STRING, length: 3)]
    private string $currency;

    #[ORM\Column(type: Types::FLOAT)]
    private float $buy;

    #[ORM\Column(type: Types::FLOAT)]
    private float $sell;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
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

    public function setCurrency(string $currency): CurrencyRate
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setBuy(float $buy): CurrencyRate
    {
        $this->buy = $buy;

        return $this;
    }

    public function getBuy(): float
    {
        return $this->buy;
    }

    public function setSell(float $sell): CurrencyRate
    {
        $this->sell = $sell;

        return $this;
    }

    public function getSell(): float
    {
        return $this->sell;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): CurrencyRate
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
