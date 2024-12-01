<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241201223447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notify (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, delay INT NOT NULL, message VARCHAR(255) DEFAULT NULL, sending_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_217BEDC8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notify ADD CONSTRAINT FK_217BEDC8A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE lunar_phase ADD notify_id INT NOT NULL');
        $this->addSql('ALTER TABLE lunar_phase ADD CONSTRAINT FK_58795B2AD5FA27FC FOREIGN KEY (notify_id) REFERENCES notify (id)');
        $this->addSql('CREATE INDEX IDX_58795B2AD5FA27FC ON lunar_phase (notify_id)');
        $this->addSql('ALTER TABLE users ADD notified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lunar_phase DROP FOREIGN KEY FK_58795B2AD5FA27FC');
        $this->addSql('ALTER TABLE notify DROP FOREIGN KEY FK_217BEDC8A76ED395');
        $this->addSql('DROP TABLE notify');
        $this->addSql('DROP INDEX IDX_58795B2AD5FA27FC ON lunar_phase');
        $this->addSql('ALTER TABLE lunar_phase DROP notify_id');
        $this->addSql('ALTER TABLE users DROP notified');
    }
}
