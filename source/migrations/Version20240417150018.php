<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240417150018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added currency rates table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE currency_rate (id INT AUTO_INCREMENT NOT NULL, provider VARCHAR(63) NOT NULL, currency VARCHAR(3) NOT NULL, buy DOUBLE PRECISION NOT NULL, sell DOUBLE PRECISION NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX idx_provider_currency (provider, currency), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE currency_rate');
    }
}
