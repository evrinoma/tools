<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190827152251 extends AbstractMigration
{
//region SECTION: Public
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mail_filter (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) DEFAULT NULL, active VARCHAR(255) NOT NULL, INDEX type (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mail_spam_rule (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, conformity VARCHAR(255) DEFAULT NULL, domain VARCHAR(512) DEFAULT NULL, hit INT NOT NULL, update_at DATETIME DEFAULT \'0000-00-00 00:00:00\', active VARCHAR(255) NOT NULL, INDEX IDX_BFD91452C54C8C93 (type_id), INDEX domain (domain), INDEX conformity (conformity), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mail_spam_rule ADD CONSTRAINT FK_BFD91452C54C8C93 FOREIGN KEY (type_id) REFERENCES mail_filter (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mail_spam_rule DROP FOREIGN KEY FK_BFD91452C54C8C93');
        $this->addSql('DROP TABLE mail_filter');
        $this->addSql('DROP TABLE mail_spam_rule');
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getDescription(): string
    {
        return '';
    }
//endregion Getters/Setters
}
