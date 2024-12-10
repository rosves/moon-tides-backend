<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241207141217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE journal ADD belongs_id INT NOT NULL');
        $this->addSql('ALTER TABLE journal ADD CONSTRAINT FK_C1A7E74D23B0270F FOREIGN KEY (belongs_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_C1A7E74D23B0270F ON journal (belongs_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE journal DROP FOREIGN KEY FK_C1A7E74D23B0270F');
        $this->addSql('DROP INDEX IDX_C1A7E74D23B0270F ON journal');
        $this->addSql('ALTER TABLE journal DROP belongs_id');
    }
}
