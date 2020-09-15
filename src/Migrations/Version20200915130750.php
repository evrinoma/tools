<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200915130750 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project ADD created_id INT DEFAULT NULL, ADD updated_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE5EE01E44 FOREIGN KEY (created_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE960CC7F3 FOREIGN KEY (updated_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE5EE01E44 ON project (created_id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE960CC7F3 ON project (updated_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE5EE01E44');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE960CC7F3');
        $this->addSql('DROP INDEX IDX_2FB3D0EE5EE01E44 ON project');
        $this->addSql('DROP INDEX IDX_2FB3D0EE960CC7F3 ON project');
        $this->addSql('ALTER TABLE project DROP created_id, DROP updated_id');
    }
}
