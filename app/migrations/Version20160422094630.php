<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160422094630 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE gallery_album ALTER params DROP NOT NULL');
        $this->addSql('ALTER TABLE gallery_photo ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gallery_photo ALTER params DROP NOT NULL');
        $this->addSql('ALTER TABLE gallery_photo ADD CONSTRAINT FK_F02A543B3DA5256D FOREIGN KEY (image_id) REFERENCES file_image (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F02A543B3DA5256D ON gallery_photo (image_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE gallery_album ALTER params SET NOT NULL');
        $this->addSql('ALTER TABLE gallery_photo DROP CONSTRAINT FK_F02A543B3DA5256D');
        $this->addSql('DROP INDEX IDX_F02A543B3DA5256D');
        $this->addSql('ALTER TABLE gallery_photo DROP image_id');
        $this->addSql('ALTER TABLE gallery_photo ALTER params SET NOT NULL');
    }
}
