<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190822140117 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mail_acl (id INT AUTO_INCREMENT NOT NULL, domain_id INT DEFAULT NULL, type VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_A09B4278115F0EE5 (domain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mail_acl ADD CONSTRAINT FK_A09B4278115F0EE5 FOREIGN KEY (domain_id) REFERENCES mail_domain (id)');
        $this->addSql('DROP TABLE tb_emails');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tb_emails (id INT AUTO_INCREMENT NOT NULL, domain_id INT DEFAULT 0 NOT NULL, type VARCHAR(50) DEFAULT \'\' NOT NULL COLLATE cp1251_general_ci, email VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE cp1251_general_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('DROP TABLE mail_acl');
    }
}
