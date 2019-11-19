<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190828145514 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mail_filter ADD pattern VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE mail_spam_rule DROP FOREIGN KEY FK_BFD914521380D476');
        $this->addSql('ALTER TABLE mail_spam_rule DROP FOREIGN KEY FK_BFD91452C54C8C93');
        $this->addSql('ALTER TABLE mail_spam_rule CHANGE update_at update_at DATETIME DEFAULT \'0000-00-00 00:00:00\'');
        $this->addSql('ALTER TABLE mail_spam_rule ADD CONSTRAINT FK_BFD914521380D476 FOREIGN KEY (conformity_id) REFERENCES mail_conformity (id)');
        $this->addSql('ALTER TABLE mail_spam_rule ADD CONSTRAINT FK_BFD91452C54C8C93 FOREIGN KEY (type_id) REFERENCES mail_filter (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mail_filter DROP pattern');
        $this->addSql('ALTER TABLE mail_spam_rule DROP FOREIGN KEY FK_BFD91452C54C8C93');
        $this->addSql('ALTER TABLE mail_spam_rule DROP FOREIGN KEY FK_BFD914521380D476');
        $this->addSql('ALTER TABLE mail_spam_rule CHANGE update_at update_at DATETIME DEFAULT \'0000-00-00 00:00:00\'');
        $this->addSql('ALTER TABLE mail_spam_rule ADD CONSTRAINT FK_BFD91452C54C8C93 FOREIGN KEY (type_id) REFERENCES mail_filter (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE mail_spam_rule ADD CONSTRAINT FK_BFD914521380D476 FOREIGN KEY (conformity_id) REFERENCES mail_conformity (id) ON UPDATE NO ACTION ON DELETE SET NULL');
    }
}
