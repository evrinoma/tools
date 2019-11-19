<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190822151310 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mail_acl ADD active VARCHAR(255) NOT NULL');
#        $this->addSql('ALTER TABLE tb_emails CHANGE domain_id domain_id INT NOT NULL, CHANGE type type VARCHAR(50) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mail_acl DROP active');
#        $this->addSql('ALTER TABLE tb_emails CHANGE domain_id domain_id INT DEFAULT 0 NOT NULL, CHANGE type type VARCHAR(50) DEFAULT \'\' NOT NULL COLLATE cp1251_general_ci, CHANGE email email VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE cp1251_general_ci');
    }
}
