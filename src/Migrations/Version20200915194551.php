<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200915194551 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contragent ADD created_id INT DEFAULT NULL, ADD updated_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contragent ADD CONSTRAINT FK_2185188B5EE01E44 FOREIGN KEY (created_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE contragent ADD CONSTRAINT FK_2185188B960CC7F3 FOREIGN KEY (updated_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_2185188B5EE01E44 ON contragent (created_id)');
        $this->addSql('CREATE INDEX IDX_2185188B960CC7F3 ON contragent (updated_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contragent DROP FOREIGN KEY FK_2185188B5EE01E44');
        $this->addSql('ALTER TABLE contragent DROP FOREIGN KEY FK_2185188B960CC7F3');
        $this->addSql('DROP INDEX IDX_2185188B5EE01E44 ON contragent');
        $this->addSql('DROP INDEX IDX_2185188B960CC7F3 ON contragent');
        $this->addSql('ALTER TABLE contragent DROP created_id, DROP updated_id');
    }
}
