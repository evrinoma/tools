<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190710090022 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, description_id INT DEFAULT NULL, host VARCHAR(255) DEFAULT NULL, port VARCHAR(255) DEFAULT NULL, remote TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_E545A0C5D9F966B (description_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE description_settings (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, instance VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, INDEX IDX_507642E1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE settings ADD CONSTRAINT FK_E545A0C5D9F966B FOREIGN KEY (description_id) REFERENCES description_settings (id)');
        $this->addSql('ALTER TABLE description_settings ADD CONSTRAINT FK_507642E1727ACA70 FOREIGN KEY (parent_id) REFERENCES description_settings (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE settings DROP FOREIGN KEY FK_E545A0C5D9F966B');
        $this->addSql('ALTER TABLE description_settings DROP FOREIGN KEY FK_507642E1727ACA70');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE description_settings');
    }
}
