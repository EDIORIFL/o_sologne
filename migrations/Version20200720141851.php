<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720141851 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, profil VARCHAR(16) DEFAULT \'commercial\' NOT NULL, name VARCHAR(64) DEFAULT \'_NOM_\' NOT NULL, iseditable TINYINT(1) DEFAULT \'1\' NOT NULL, isactive TINYINT(1) DEFAULT \'1\' NOT NULL, createdat DATETIME DEFAULT \'2016-01-01 00:00:00\' NOT NULL, updatedat DATETIME DEFAULT \'2016-01-01 00:00:00\' NOT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE command CHANGE turnover turnover DOUBLE PRECISION NOT NULL, CHANGE rib rib VARCHAR(20) NOT NULL, CHANGE paymentmode paymentmode VARCHAR(3) NOT NULL, CHANGE payment payment VARCHAR(20) NOT NULL, CHANGE ismockfile ismockfile TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE prospect CHANGE manager manager VARCHAR(50) NOT NULL, CHANGE telephone telephone VARCHAR(15) NOT NULL, CHANGE mobile mobile VARCHAR(15) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE command CHANGE turnover turnover DOUBLE PRECISION DEFAULT \'0\' NOT NULL, CHANGE rib rib VARCHAR(20) CHARACTER SET latin1 DEFAULT \'\' NOT NULL COLLATE `latin1_swedish_ci`, CHANGE paymentmode paymentmode VARCHAR(3) CHARACTER SET latin1 DEFAULT \'\' NOT NULL COLLATE `latin1_swedish_ci`, CHANGE payment payment VARCHAR(20) CHARACTER SET latin1 DEFAULT \'\' NOT NULL COLLATE `latin1_swedish_ci`, CHANGE ismockfile ismockfile TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE prospect CHANGE manager manager VARCHAR(50) CHARACTER SET latin1 DEFAULT \'\' NOT NULL COLLATE `latin1_swedish_ci`, CHANGE telephone telephone VARCHAR(15) CHARACTER SET latin1 DEFAULT \'\' NOT NULL COLLATE `latin1_swedish_ci`, CHANGE mobile mobile VARCHAR(15) CHARACTER SET latin1 DEFAULT \'\' NOT NULL COLLATE `latin1_swedish_ci`, CHANGE email email VARCHAR(255) CHARACTER SET latin1 DEFAULT \'\' NOT NULL COLLATE `latin1_swedish_ci`');
    }
}
