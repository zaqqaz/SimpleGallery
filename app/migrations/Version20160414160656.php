<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160414160656 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE exercise_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE gallery_photo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE file_image (id INT NOT NULL, path VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE gallery_album (id INT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, is_deleted BOOLEAN DEFAULT \'false\' NOT NULL, params JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DD05BE605E237E06 ON gallery_album (name)');
        $this->addSql('CREATE INDEX IDX_DD05BE603DA5256D ON gallery_album (image_id)');
        $this->addSql('CREATE TABLE gallery_photo (id INT NOT NULL, gallery_album_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, params JSON NOT NULL, is_deleted BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F02A543B5E237E06 ON gallery_photo (name)');
        $this->addSql('CREATE INDEX IDX_F02A543B24BA7974 ON gallery_photo (gallery_album_id)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, last_name VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, middle_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, birthday DATE DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, last_activity_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, last_auth_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, password VARCHAR(255) NOT NULL, salt VARCHAR(255) NOT NULL, roles TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('COMMENT ON COLUMN users.roles IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE user_session (id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, login_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, logout_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8849CBDE5F37A13B ON user_session (token)');
        $this->addSql('CREATE INDEX IDX_8849CBDEA76ED395 ON user_session (user_id)');
        $this->addSql('CREATE TABLE user_settings (id INT NOT NULL, user_id INT DEFAULT NULL, language CHAR(2) DEFAULT \'ru\' NOT NULL, word_repetition_type VARCHAR(255) DEFAULT NULL, allow_email_word_repetition_notify BOOLEAN DEFAULT \'true\' NOT NULL, allow_email_administrative_notify BOOLEAN DEFAULT \'true\' NOT NULL, allow_sms_word_repetition_notify BOOLEAN DEFAULT \'true\' NOT NULL, allow_sms_administrative_notify BOOLEAN DEFAULT \'true\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C844C5A76ED395 ON user_settings (user_id)');
        $this->addSql('ALTER TABLE gallery_album ADD CONSTRAINT FK_DD05BE603DA5256D FOREIGN KEY (image_id) REFERENCES file_image (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE gallery_photo ADD CONSTRAINT FK_F02A543B24BA7974 FOREIGN KEY (gallery_album_id) REFERENCES gallery_album (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_session ADD CONSTRAINT FK_8849CBDEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_settings ADD CONSTRAINT FK_5C844C5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE gallery_album DROP CONSTRAINT FK_DD05BE603DA5256D');
        $this->addSql('ALTER TABLE gallery_photo DROP CONSTRAINT FK_F02A543B24BA7974');
        $this->addSql('ALTER TABLE user_session DROP CONSTRAINT FK_8849CBDEA76ED395');
        $this->addSql('ALTER TABLE user_settings DROP CONSTRAINT FK_5C844C5A76ED395');
        $this->addSql('DROP SEQUENCE gallery_photo_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE exercise_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE file_image');
        $this->addSql('DROP TABLE gallery_album');
        $this->addSql('DROP TABLE gallery_photo');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE user_session');
        $this->addSql('DROP TABLE user_settings');
    }
}
