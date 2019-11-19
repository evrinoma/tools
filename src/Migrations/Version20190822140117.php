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
        $this->addSql('CREATE TABLE mail_domain (id INT AUTO_INCREMENT NOT NULL, server_id INT DEFAULT NULL, domain VARCHAR(255) NOT NULL, active VARCHAR(255) NOT NULL, INDEX IDX_7A90A1601844E6B7 (server_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mail_server (id INT AUTO_INCREMENT NOT NULL, server_id INT DEFAULT NULL, ip VARCHAR(255) NOT NULL, hostname VARCHAR(255) NOT NULL, active VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mail_acl ADD CONSTRAINT FK_A09B4278115F0EE5 FOREIGN KEY (domain_id) REFERENCES mail_domain (id)');
        $this->addSql('ALTER TABLE mail_domain ADD CONSTRAINT FK_7A90A1601844E6B7 FOREIGN KEY (server_id) REFERENCES mail_server (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE mail_acl');
        $this->addSql('DROP TABLE mail_domain');
        $this->addSql('DROP TABLE mail_server');
    }
}
