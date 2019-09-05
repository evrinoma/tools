<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190905061413 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE PARAMS DROP FOREIGN KEY FK_7F36C975FE08514F');
        $this->addSql('ALTER TABLE PARAMS DROP FOREIGN KEY FK_7F36C97547405208');
        $this->addSql('ALTER TABLE PARAMS DROP FOREIGN KEY FK_7F36C9759497FC04');
        $this->addSql('ALTER TABLE PARAMS DROP FOREIGN KEY FK_7F36C975EBD84B70');
        $this->addSql('ALTER TABLE live_cam DROP FOREIGN KEY FK_E6FB58C4FE54D947');
        $this->addSql('ALTER TABLE live_cam DROP FOREIGN KEY FK_E6FB58C4C54C8C93');
        $this->addSql('DROP TABLE DEVICES');
        $this->addSql('DROP TABLE DiscreetInfo');
        $this->addSql('DROP TABLE GROUPS');
        $this->addSql('DROP TABLE PARAMS');
        $this->addSql('DROP TABLE SCALES');
        $this->addSql('DROP TABLE SCRIPT_ENGINES');
        $this->addSql('DROP TABLE live_cam');
        $this->addSql('DROP TABLE live_group');
        $this->addSql('DROP TABLE live_type');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE DEVICES (ID INT AUTO_INCREMENT NOT NULL, NAME VARCHAR(254) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE DiscreetInfo (N INT NOT NULL, T INT NOT NULL, V INT NOT NULL, S INT NOT NULL, XS INT NOT NULL, PRIMARY KEY(N, T)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE GROUPS (ID INT AUTO_INCREMENT NOT NULL, NAME VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE PARAMS (ID INT AUTO_INCREMENT NOT NULL, PARAMTYPE INT NOT NULL, DEVICECHAN VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, DS_ID INT NOT NULL, DS_CHAN VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, NAME VARCHAR(254) NOT NULL COLLATE utf8mb4_unicode_ci, ADDITIONALNAME VARCHAR(254) DEFAULT NULL COLLATE utf8mb4_unicode_ci, SHORTNAME VARCHAR(20) DEFAULT NULL COLLATE utf8mb4_unicode_ci, AKS VARCHAR(20) DEFAULT NULL COLLATE utf8mb4_unicode_ci, FLAGS INT NOT NULL, SCRIPT_TEXT TINYTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, SCANRATE SMALLINT NOT NULL, `INTERVAL` SMALLINT NOT NULL, ALARMDELAY SMALLINT NOT NULL, STALETIMEOUT SMALLINT NOT NULL, CALCTIME INT NOT NULL, SAVETIME INT NOT NULL, STEP SMALLINT NOT NULL, METATYPE CHAR(36) DEFAULT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:guid)\', SCALEID INT DEFAULT NULL, DEVICEID INT DEFAULT NULL, SCRIPT_ENGINE_ID INT DEFAULT NULL, GROUPID INT DEFAULT NULL, INDEX IDX_7F36C9759497FC04 (SCALEID), INDEX IDX_7F36C975EBD84B70 (SCRIPT_ENGINE_ID), INDEX IDX_7F36C975FE08514F (DEVICEID), INDEX IDX_7F36C97547405208 (GROUPID), PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE SCALES (ID INT AUTO_INCREMENT NOT NULL, TYPE INT NOT NULL, UNIT VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, MINVALUE DOUBLE PRECISION NOT NULL, `MAXVALUE` DOUBLE PRECISION NOT NULL, `PRECISION` INT DEFAULT -1 NOT NULL, NAME VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci, FORMAT VARCHAR(254) DEFAULT NULL COLLATE utf8mb4_unicode_ci, AGCOEFF DOUBLE PRECISION DEFAULT NULL, AGUNITS VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE SCRIPT_ENGINES (ID INT AUTO_INCREMENT NOT NULL, NAME VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, PROGID VARCHAR(254) NOT NULL COLLATE utf8mb4_unicode_ci, SOURCE_CODE TINYTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE live_cam (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, group_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, ip VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, user_name VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, password VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, link VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, stream VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, title VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, control TINYINT(1) NOT NULL, active VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, startPlay TINYINT(1) NOT NULL, INDEX IDX_E6FB58C4C54C8C93 (type_id), INDEX IDX_E6FB58C4FE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE live_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, alias VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, max_column INT NOT NULL, active VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE live_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, active VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE PARAMS ADD CONSTRAINT FK_7F36C97547405208 FOREIGN KEY (GROUPID) REFERENCES GROUPS (ID)');
        $this->addSql('ALTER TABLE PARAMS ADD CONSTRAINT FK_7F36C9759497FC04 FOREIGN KEY (SCALEID) REFERENCES SCALES (ID)');
        $this->addSql('ALTER TABLE PARAMS ADD CONSTRAINT FK_7F36C975EBD84B70 FOREIGN KEY (SCRIPT_ENGINE_ID) REFERENCES SCRIPT_ENGINES (ID)');
        $this->addSql('ALTER TABLE PARAMS ADD CONSTRAINT FK_7F36C975FE08514F FOREIGN KEY (DEVICEID) REFERENCES DEVICES (ID)');
        $this->addSql('ALTER TABLE live_cam ADD CONSTRAINT FK_E6FB58C4C54C8C93 FOREIGN KEY (type_id) REFERENCES live_type (id)');
        $this->addSql('ALTER TABLE live_cam ADD CONSTRAINT FK_E6FB58C4FE54D947 FOREIGN KEY (group_id) REFERENCES live_group (id)');
    }
}
