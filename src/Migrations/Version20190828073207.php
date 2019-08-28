<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190828073207 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mail_conformity (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) DEFAULT NULL, active VARCHAR(255) NOT NULL, INDEX type (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP INDEX type ON mail_filter');
        $this->addSql('CREATE INDEX type ON mail_filter (type)');
        $this->addSql('DROP INDEX conformity ON mail_spam_rule');
        $this->addSql('DROP INDEX domain ON mail_spam_rule');
        $this->addSql('ALTER TABLE mail_spam_rule ADD conformity_id INT DEFAULT NULL, DROP conformity, CHANGE update_at update_at DATETIME DEFAULT \'0000-00-00 00:00:00\'');
        $this->addSql('ALTER TABLE mail_spam_rule ADD CONSTRAINT FK_BFD914521380D476 FOREIGN KEY (conformity_id) REFERENCES mail_conformity (id)');
        $this->addSql('CREATE INDEX IDX_BFD914521380D476 ON mail_spam_rule (conformity_id)');
        $this->addSql('CREATE INDEX domain ON mail_spam_rule (domain)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mail_spam_rule DROP FOREIGN KEY FK_BFD914521380D476');
        $this->addSql('DROP TABLE mail_conformity');
        $this->addSql('DROP INDEX type ON mail_filter');
        $this->addSql('CREATE INDEX type ON mail_filter (type(191))');
        $this->addSql('DROP INDEX IDX_BFD914521380D476 ON mail_spam_rule');
        $this->addSql('DROP INDEX domain ON mail_spam_rule');
        $this->addSql('ALTER TABLE mail_spam_rule ADD conformity VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP conformity_id, CHANGE update_at update_at DATETIME DEFAULT \'0000-00-00 00:00:00\'');
        $this->addSql('CREATE INDEX conformity ON mail_spam_rule (conformity(191))');
        $this->addSql('CREATE INDEX domain ON mail_spam_rule (domain(191))');
    }
}
