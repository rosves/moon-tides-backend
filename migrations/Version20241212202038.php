<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241212202038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lunar_phase_ritual DROP FOREIGN KEY FK_E3432E26230D4B59');
        $this->addSql('ALTER TABLE lunar_phase_ritual DROP FOREIGN KEY FK_E3432E26F8922643');
        $this->addSql('DROP TABLE lunar_phase_ritual');
        $this->addSql('ALTER TABLE lunar_phase DROP start_date, DROP end_date, DROP moon_sign');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lunar_phase_ritual (lunar_phase_id INT NOT NULL, ritual_id INT NOT NULL, INDEX IDX_E3432E26230D4B59 (lunar_phase_id), INDEX IDX_E3432E26F8922643 (ritual_id), PRIMARY KEY(lunar_phase_id, ritual_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE lunar_phase_ritual ADD CONSTRAINT FK_E3432E26230D4B59 FOREIGN KEY (lunar_phase_id) REFERENCES lunar_phase (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lunar_phase_ritual ADD CONSTRAINT FK_E3432E26F8922643 FOREIGN KEY (ritual_id) REFERENCES ritual (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lunar_phase ADD start_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD end_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD moon_sign VARCHAR(50) NOT NULL');
    }
}
