<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516191837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `message_demo` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', message VARCHAR(255) NOT NULL, date_created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', type ENUM(\'notice\',\'alarm\') NOT NULL COMMENT \'(DC2Type:message_type)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `message_demo`');
    }
}
