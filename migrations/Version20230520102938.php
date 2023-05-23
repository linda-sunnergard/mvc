<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230520102938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE preschool (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, education_level VARCHAR(255) NOT NULL, percentage DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__education AS SELECT id, gender, year, education_level, percentage FROM education');
        $this->addSql('DROP TABLE education');
        $this->addSql('CREATE TABLE education (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, gender VARCHAR(255) NOT NULL, year INTEGER NOT NULL, education_level VARCHAR(255) NOT NULL, percentage DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO education (id, gender, year, education_level, percentage) SELECT id, gender, year, education_level, percentage FROM __temp__education');
        $this->addSql('DROP TABLE __temp__education');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE preschool');
        $this->addSql('CREATE TEMPORARY TABLE __temp__education AS SELECT id, gender, year, education_level, percentage FROM education');
        $this->addSql('DROP TABLE education');
        $this->addSql('CREATE TABLE education (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, gender VARCHAR(255) NOT NULL, year INTEGER NOT NULL, education_level VARCHAR(255) NOT NULL, percentage INTEGER NOT NULL)');
        $this->addSql('INSERT INTO education (id, gender, year, education_level, percentage) SELECT id, gender, year, education_level, percentage FROM __temp__education');
        $this->addSql('DROP TABLE __temp__education');
    }
}
