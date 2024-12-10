<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241201213106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, content LONGTEXT NOT NULL, publication_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE journal (id INT AUTO_INCREMENT NOT NULL, add_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', note_entry LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lunar_phase (id INT AUTO_INCREMENT NOT NULL, phase_name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, start_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, message LONGTEXT NOT NULL, sending_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', type_notification VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ritual (id INT AUTO_INCREMENT NOT NULL, ritual_name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, label_role VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, journal_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(100) NOT NULL, date_creation DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1483A5E9478E8802 (journal_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9478E8802 FOREIGN KEY (journal_id) REFERENCES journal (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9478E8802');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE journal');
        $this->addSql('DROP TABLE lunar_phase');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE ritual');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE users');
    }
}
