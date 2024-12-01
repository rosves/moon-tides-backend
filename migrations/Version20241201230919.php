<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241201230919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD notifymoon_id INT NOT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E91490F36F FOREIGN KEY (notifymoon_id) REFERENCES moon_notification (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E91490F36F ON users (notifymoon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E91490F36F');
        $this->addSql('DROP INDEX UNIQ_1483A5E91490F36F ON users');
        $this->addSql('ALTER TABLE users DROP notifymoon_id');
    }
}
