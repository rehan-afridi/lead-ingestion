<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240714193508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE keeper_history (id INT AUTO_INCREMENT NOT NULL, lead_id INT NOT NULL, keeper_name VARCHAR(255) NOT NULL, INDEX IDX_901A879D55458D (lead_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lead (leadid INT NOT NULL, postcode VARCHAR(8) NOT NULL, model VARCHAR(255) NOT NULL, reg_year INT NOT NULL, cylinder_capacity INT NOT NULL, color VARCHAR(255) NOT NULL, keepers_count INT NOT NULL, contact VARCHAR(15) NOT NULL, email VARCHAR(255) NOT NULL, fuel VARCHAR(56) NOT NULL, transmission VARCHAR(56) NOT NULL, doors INT NOT NULL, mot_due DATETIME NOT NULL, vin VARCHAR(17) NOT NULL, PRIMARY KEY(leadid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE keeper_history ADD CONSTRAINT FK_901A879D55458D FOREIGN KEY (lead_id) REFERENCES lead (leadid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE keeper_history DROP FOREIGN KEY FK_901A879D55458D');
        $this->addSql('DROP TABLE keeper_history');
        $this->addSql('DROP TABLE lead');
    }
}
