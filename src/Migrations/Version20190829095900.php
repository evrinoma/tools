<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190829095900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE live_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL, active VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE live_cam (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, group_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, ip VARCHAR(50) NOT NULL, user_name VARCHAR(50) NOT NULL, password VARCHAR(50) NOT NULL, link VARCHAR(50) NOT NULL, stream VARCHAR(50) NOT NULL, title VARCHAR(50) NOT NULL, control TINYINT(1) NOT NULL, active VARCHAR(255) NOT NULL, INDEX IDX_E6FB58C4C54C8C93 (type_id), INDEX IDX_E6FB58C4FE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE live_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, alias VARCHAR(50) NOT NULL, max_column INT NOT NULL, active VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE live_cam ADD CONSTRAINT FK_E6FB58C4C54C8C93 FOREIGN KEY (type_id) REFERENCES live_type (id)');
        $this->addSql('ALTER TABLE live_cam ADD CONSTRAINT FK_E6FB58C4FE54D947 FOREIGN KEY (group_id) REFERENCES live_group (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE live_cam DROP FOREIGN KEY FK_E6FB58C4C54C8C93');
        $this->addSql('ALTER TABLE live_cam DROP FOREIGN KEY FK_E6FB58C4FE54D947');
        $this->addSql('DROP TABLE live_type');
        $this->addSql('DROP TABLE live_cam');
        $this->addSql('DROP TABLE live_group');
    }
}
