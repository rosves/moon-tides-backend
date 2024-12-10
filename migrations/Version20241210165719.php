<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241210165719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE note_entries (id INT AUTO_INCREMENT NOT NULL, create_note_id INT DEFAULT NULL, note_content LONGTEXT NOT NULL, note_title VARCHAR(100) NOT NULL, note_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_AC5E775F4D59F52 (create_note_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE note_entries ADD CONSTRAINT FK_AC5E775F4D59F52 FOREIGN KEY (create_note_id) REFERENCES journal (id)');
        $this->addSql('ALTER TABLE journal DROP add_date, DROP note_entry');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note_entries DROP FOREIGN KEY FK_AC5E775F4D59F52');
        $this->addSql('DROP TABLE note_entries');
        $this->addSql('ALTER TABLE journal ADD add_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD note_entry LONGTEXT DEFAULT NULL');
    }
}
