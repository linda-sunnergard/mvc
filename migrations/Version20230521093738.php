<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230521093738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE health_economy (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, gender VARCHAR(255) NOT NULL, education_level VARCHAR(255) NOT NULL, needed_care DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TABLE health_education (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, gender VARCHAR(255) NOT NULL, education_level VARCHAR(255) NOT NULL, self_rated_health DOUBLE PRECISION NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE health_economy');
        $this->addSql('DROP TABLE health_education');
    }
}
