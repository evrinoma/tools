<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190816123846 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE DEVICES (ID INT AUTO_INCREMENT NOT NULL, NAME VARCHAR(254) NOT NULL, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE GROUPS (ID INT AUTO_INCREMENT NOT NULL, NAME VARCHAR(50) NOT NULL, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE SCALES (ID INT AUTO_INCREMENT NOT NULL, TYPE INT NOT NULL, UNIT VARCHAR(50) NOT NULL, MINVALUE DOUBLE PRECISION NOT NULL, `MAXVALUE` DOUBLE PRECISION NOT NULL, `PRECISION` INT DEFAULT -1 NOT NULL, NAME VARCHAR(50) DEFAULT NULL, FORMAT VARCHAR(254) DEFAULT NULL, AGCOEFF DOUBLE PRECISION DEFAULT NULL, AGUNITS VARCHAR(50) DEFAULT NULL, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE SCRIPT_ENGINES (ID INT AUTO_INCREMENT NOT NULL, NAME VARCHAR(50) NOT NULL, PROGID VARCHAR(254) NOT NULL, SOURCE_CODE TINYTEXT DEFAULT NULL, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE DiscreetInfo (N INT NOT NULL, T INT NOT NULL, V INT NOT NULL, S INT NOT NULL, XS INT NOT NULL, PRIMARY KEY(N, T)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE PARAMS (ID INT AUTO_INCREMENT NOT NULL, PARAMTYPE INT NOT NULL, DEVICECHAN VARCHAR(50) NOT NULL, DS_ID INT NOT NULL, DS_CHAN VARCHAR(50) NOT NULL, NAME VARCHAR(254) NOT NULL, ADDITIONALNAME VARCHAR(254) DEFAULT NULL, SHORTNAME VARCHAR(20) DEFAULT NULL, AKS VARCHAR(20) DEFAULT NULL, FLAGS INT NOT NULL, SCRIPT_TEXT TINYTEXT DEFAULT NULL, SCANRATE SMALLINT NOT NULL, `INTERVAL` SMALLINT NOT NULL, ALARMDELAY SMALLINT NOT NULL, STALETIMEOUT SMALLINT NOT NULL, CALCTIME INT NOT NULL, SAVETIME INT NOT NULL, STEP SMALLINT NOT NULL, METATYPE CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', SCALEID INT DEFAULT NULL, DEVICEID INT DEFAULT NULL, SCRIPT_ENGINE_ID INT DEFAULT NULL, GROUPID INT DEFAULT NULL, INDEX IDX_7F36C9759497FC04 (SCALEID), INDEX IDX_7F36C975FE08514F (DEVICEID), INDEX IDX_7F36C975EBD84B70 (SCRIPT_ENGINE_ID), INDEX IDX_7F36C97547405208 (GROUPID), PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE PARAMS ADD CONSTRAINT FK_7F36C9759497FC04 FOREIGN KEY (SCALEID) REFERENCES SCALES (ID)');
        $this->addSql('ALTER TABLE PARAMS ADD CONSTRAINT FK_7F36C975FE08514F FOREIGN KEY (DEVICEID) REFERENCES DEVICES (ID)');
        $this->addSql('ALTER TABLE PARAMS ADD CONSTRAINT FK_7F36C975EBD84B70 FOREIGN KEY (SCRIPT_ENGINE_ID) REFERENCES SCRIPT_ENGINES (ID)');
        $this->addSql('ALTER TABLE PARAMS ADD CONSTRAINT FK_7F36C97547405208 FOREIGN KEY (GROUPID) REFERENCES GROUPS (ID)');
        $this->addSql('DROP TABLE tb_emails');
        $this->addSql('DROP TABLE tb_spam_fishing');
        $this->addSql('DROP TABLE tb_spam_hits');
        $this->addSql('DROP TABLE tb_spam_rules');
        $this->addSql('ALTER TABLE settings ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tb_domains CHANGE owner_id owner_id INT NOT NULL, CHANGE domain domain VARCHAR(255) NOT NULL, CHANGE geoip geoip INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE PARAMS DROP FOREIGN KEY FK_7F36C975FE08514F');
        $this->addSql('ALTER TABLE PARAMS DROP FOREIGN KEY FK_7F36C97547405208');
        $this->addSql('ALTER TABLE PARAMS DROP FOREIGN KEY FK_7F36C9759497FC04');
        $this->addSql('ALTER TABLE PARAMS DROP FOREIGN KEY FK_7F36C975EBD84B70');
        $this->addSql('CREATE TABLE tb_emails (id INT AUTO_INCREMENT NOT NULL, domain_id INT DEFAULT 0 NOT NULL, type VARCHAR(50) DEFAULT \'\' NOT NULL COLLATE cp1251_general_ci, email VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE cp1251_general_ci, UNIQUE INDEX id (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tb_spam_fishing (id INT AUTO_INCREMENT NOT NULL, tb_spam_rules INT DEFAULT NULL, sender_host_name VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, sender_helo_name VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, sender_ident VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, local_part VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, sender_address_local_part VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, UNIQUE INDEX sender_host_name (sender_host_name, sender_helo_name, sender_ident, local_part), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tb_spam_hits (id INT AUTO_INCREMENT NOT NULL, tb_spam_rules INT NOT NULL, time DATETIME DEFAULT CURRENT_TIMESTAMP, destination TEXT DEFAULT NULL COLLATE latin1_swedish_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tb_spam_rules (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, conformity VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, domain VARCHAR(512) DEFAULT NULL COLLATE latin1_swedish_ci, hit INT DEFAULT 0 NOT NULL, update_at DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX type (type), INDEX domain (domain), INDEX conformity (conformity), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE DEVICES');
        $this->addSql('DROP TABLE GROUPS');
        $this->addSql('DROP TABLE SCALES');
        $this->addSql('DROP TABLE SCRIPT_ENGINES');
        $this->addSql('DROP TABLE DiscreetInfo');
        $this->addSql('DROP TABLE PARAMS');
        $this->addSql('ALTER TABLE settings DROP type');
        $this->addSql('ALTER TABLE tb_domains CHANGE owner_id owner_id INT DEFAULT 0 NOT NULL, CHANGE domain domain VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE cp1251_general_ci, CHANGE geoip geoip INT DEFAULT 0 NOT NULL');
    }
}
