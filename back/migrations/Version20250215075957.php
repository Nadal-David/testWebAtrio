<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250215075957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE emploi_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE personne_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE emploi (id INT NOT NULL, personne_id INT NOT NULL, nom_entreprise VARCHAR(255) NOT NULL, poste VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_74A0B0FAA21BD112 ON emploi (personne_id)');
        $this->addSql('CREATE TABLE personne (id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE emploi ADD CONSTRAINT FK_74A0B0FAA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE emploi_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE personne_id_seq CASCADE');
        $this->addSql('ALTER TABLE emploi DROP CONSTRAINT FK_74A0B0FAA21BD112');
        $this->addSql('DROP TABLE emploi');
        $this->addSql('DROP TABLE personne');
    }
}
