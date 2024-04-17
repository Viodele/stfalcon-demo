<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\CurrencyRate;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

final class CurrencyRateRepository extends ServiceEntityRepository
{
    public const ALIAS = 'cr';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, CurrencyRate::class);
    }

    public function save(CurrencyRate $entity): void
    {
        $entity->setUpdatedAt(new DateTimeImmutable());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
