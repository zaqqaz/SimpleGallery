<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160422201857 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX uniq_dd05be605e237e06');
        $this->addSql('ALTER TABLE gallery_album ALTER description DROP NOT NULL');
        $this->addSql('DROP INDEX uniq_f02a543b5e237e06');
        $this->addSql('ALTER TABLE gallery_photo ADD description VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE gallery_photo DROP description');
        $this->addSql('CREATE UNIQUE INDEX uniq_f02a543b5e237e06 ON gallery_photo (name)');
        $this->addSql('ALTER TABLE gallery_album ALTER description SET NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_dd05be605e237e06 ON gallery_album (name)');
    }
}
