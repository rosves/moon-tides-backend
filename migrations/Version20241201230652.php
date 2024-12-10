<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241201230652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE moon_notification (id INT AUTO_INCREMENT NOT NULL, full_moon_notify TINYINT(1) NOT NULL, new_moon_notify TINYINT(1) NOT NULL, solar_eclipse_notify TINYINT(1) NOT NULL, moon_eclipse_notify TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE notification');
        $this->addSql('ALTER TABLE lunar_phase ADD moon_sign VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE users DROP notified');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, message LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sending_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', type_notification VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE moon_notification');
        $this->addSql('ALTER TABLE lunar_phase DROP moon_sign');
        $this->addSql('ALTER TABLE users ADD notified TINYINT(1) NOT NULL');
    }
}
