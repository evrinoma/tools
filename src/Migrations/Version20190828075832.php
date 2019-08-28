<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190828075832 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX type ON mail_conformity');
        $this->addSql('DROP INDEX type ON mail_filter');
        $this->addSql('ALTER TABLE mail_spam_rule CHANGE update_at update_at DATETIME DEFAULT \'0000-00-00 00:00:00\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE INDEX type ON mail_conformity (type(191))');
        $this->addSql('CREATE INDEX type ON mail_filter (type(191))');
        $this->addSql('ALTER TABLE mail_spam_rule CHANGE update_at update_at DATETIME DEFAULT \'0000-00-00 00:00:00\'');
    }
}
