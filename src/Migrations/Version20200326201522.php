<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200326201522 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX IDX_E545A0C5D9F966B ON settings');
        $this->addSql('ALTER TABLE settings DROP description_id, DROP host, DROP port, DROP remote');
        $this->addSql('ALTER TABLE description_settings ADD CONSTRAINT FK_507642E1727ACA70 FOREIGN KEY (parent_id) REFERENCES description_settings (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE description_settings DROP FOREIGN KEY FK_507642E1727ACA70');
        $this->addSql('ALTER TABLE settings ADD description_id INT DEFAULT NULL, ADD host VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD port VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD remote TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('CREATE INDEX IDX_E545A0C5D9F966B ON settings (description_id)');
    }
}
