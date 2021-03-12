<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310195031 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, practitioner_id INT NOT NULL, patient_id INT NOT NULL, reason_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_FE38F8441121EA2C (practitioner_id), INDEX IDX_FE38F8446B899279 (patient_id), UNIQUE INDEX UNIQ_FE38F84459BB1592 (reason_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reason (id INT AUTO_INCREMENT NOT NULL, constant VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE practitioners_specialities (speciality_id INT NOT NULL, practitioner_id INT NOT NULL, INDEX IDX_D79371F3B5A08D7 (speciality_id), INDEX IDX_D79371F1121EA2C (practitioner_id), PRIMARY KEY(speciality_id, practitioner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE practitioners_languages (practitioner_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_536741981121EA2C (practitioner_id), INDEX IDX_5367419882F1BAF4 (language_id), PRIMARY KEY(practitioner_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8441121EA2C FOREIGN KEY (practitioner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8446B899279 FOREIGN KEY (patient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84459BB1592 FOREIGN KEY (reason_id) REFERENCES reason (id)');
        $this->addSql('ALTER TABLE practitioners_specialities ADD CONSTRAINT FK_D79371F3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)');
        $this->addSql('ALTER TABLE practitioners_specialities ADD CONSTRAINT FK_D79371F1121EA2C FOREIGN KEY (practitioner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE practitioners_languages ADD CONSTRAINT FK_536741981121EA2C FOREIGN KEY (practitioner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE practitioners_languages ADD CONSTRAINT FK_5367419882F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE practitioners_languages DROP FOREIGN KEY FK_5367419882F1BAF4');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F84459BB1592');
        $this->addSql('ALTER TABLE practitioners_specialities DROP FOREIGN KEY FK_D79371F3B5A08D7');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8441121EA2C');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8446B899279');
        $this->addSql('ALTER TABLE practitioners_specialities DROP FOREIGN KEY FK_D79371F1121EA2C');
        $this->addSql('ALTER TABLE practitioners_languages DROP FOREIGN KEY FK_536741981121EA2C');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE reason');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('DROP TABLE practitioners_specialities');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE practitioners_languages');
    }
}
