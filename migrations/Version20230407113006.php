<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407113006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `group` ADD main_author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C5D6C354B9 FOREIGN KEY (main_author_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_6DC044C5D6C354B9 ON `group` (main_author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C5D6C354B9');
        $this->addSql('DROP INDEX IDX_6DC044C5D6C354B9 ON `group`');
        $this->addSql('ALTER TABLE `group` DROP main_author_id');
    }
}
