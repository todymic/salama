<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312220853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE app_entity_appointment (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE availability (id INT AUTO_INCREMENT NOT NULL, practitioner_id INT NOT NULL, day DATE NOT NULL, hour TIME NOT NULL, status VARCHAR(255) NOT NULL, locality INT NOT NULL, INDEX IDX_3FB7A2BF1121EA2C (practitioner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE degree (id INT AUTO_INCREMENT NOT NULL, practitioner_id INT NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_A7A36D631121EA2C (practitioner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE locality (id INT AUTO_INCREMENT NOT NULL, practitioner_id INT NOT NULL, street_type VARCHAR(255) NOT NULL, street_name VARCHAR(255) NOT NULL, zipcode INT NOT NULL, street_number INT NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, INDEX IDX_E1D6B8E61121EA2C (practitioner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, gender ENUM(\'M\', \'F\'), civility ENUM(\'Mr\', \'Mrs\', \'Ms\'), description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE practitioners_languages (practitioner_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_536741981121EA2C (practitioner_id), INDEX IDX_5367419882F1BAF4 (language_id), PRIMARY KEY(practitioner_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BF1121EA2C FOREIGN KEY (practitioner_id) REFERENCES user (id)'
        );
        $this->addSql(
            'ALTER TABLE degree ADD CONSTRAINT FK_A7A36D631121EA2C FOREIGN KEY (practitioner_id) REFERENCES user (id)'
        );
        $this->addSql(
            'ALTER TABLE locality ADD CONSTRAINT FK_E1D6B8E61121EA2C FOREIGN KEY (practitioner_id) REFERENCES user (id)'
        );
        $this->addSql(
            'ALTER TABLE practitioners_languages ADD CONSTRAINT FK_536741981121EA2C FOREIGN KEY (practitioner_id) REFERENCES user (id)'
        );
        $this->addSql(
            'ALTER TABLE practitioners_languages ADD CONSTRAINT FK_5367419882F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)'
        );
        $this->addSql('ALTER TABLE appointment ADD availability_id INT NOT NULL');
        $this->addSql(
            'ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8441121EA2C FOREIGN KEY (practitioner_id) REFERENCES user (id)'
        );
        $this->addSql(
            'ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8446B899279 FOREIGN KEY (patient_id) REFERENCES user (id)'
        );
        $this->addSql(
            'ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84459BB1592 FOREIGN KEY (reason_id) REFERENCES reason (id)'
        );
        $this->addSql(
            'ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84461778466 FOREIGN KEY (availability_id) REFERENCES availability (id)'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FE38F84461778466 ON appointment (availability_id)');
        $this->addSql(
            'ALTER TABLE practitioners_specialities ADD CONSTRAINT FK_D79371F3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)'
        );
        $this->addSql(
            'ALTER TABLE practitioners_specialities ADD CONSTRAINT FK_D79371F1121EA2C FOREIGN KEY (practitioner_id) REFERENCES user (id)'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F84461778466');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8441121EA2C');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8446B899279');
        $this->addSql('ALTER TABLE availability DROP FOREIGN KEY FK_3FB7A2BF1121EA2C');
        $this->addSql('ALTER TABLE degree DROP FOREIGN KEY FK_A7A36D631121EA2C');
        $this->addSql('ALTER TABLE locality DROP FOREIGN KEY FK_E1D6B8E61121EA2C');
        $this->addSql('ALTER TABLE practitioners_specialities DROP FOREIGN KEY FK_D79371F1121EA2C');
        $this->addSql('ALTER TABLE practitioners_languages DROP FOREIGN KEY FK_536741981121EA2C');
        $this->addSql('DROP TABLE app_entity_appointment');
        $this->addSql('DROP TABLE availability');
        $this->addSql('DROP TABLE degree');
        $this->addSql('DROP TABLE locality');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE practitioners_languages');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F84459BB1592');
        $this->addSql('DROP INDEX UNIQ_FE38F84461778466 ON appointment');
        $this->addSql('ALTER TABLE appointment DROP availability_id');
        $this->addSql('ALTER TABLE practitioners_specialities DROP FOREIGN KEY FK_D79371F3B5A08D7');
    }
}
