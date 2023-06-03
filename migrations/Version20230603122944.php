<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230603122944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_auth_token (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, value VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_C50E5B32A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C50E5B32A76ED395 ON app_auth_token (user_id)');
        $this->addSql('CREATE UNIQUE INDEX auth_token_value_unique ON app_auth_token (value)');
        $this->addSql('CREATE TABLE app_place (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX places_name_unique ON app_place (name)');
        $this->addSql('CREATE TABLE app_place_theme (place_id INTEGER NOT NULL, theme_id INTEGER NOT NULL, PRIMARY KEY(place_id, theme_id), CONSTRAINT FK_67E6DA97DA6A219 FOREIGN KEY (place_id) REFERENCES app_place (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_67E6DA9759027487 FOREIGN KEY (theme_id) REFERENCES app_theme (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_67E6DA97DA6A219 ON app_place_theme (place_id)');
        $this->addSql('CREATE INDEX IDX_67E6DA9759027487 ON app_place_theme (theme_id)');
        $this->addSql('CREATE TABLE app_preference (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, value INTEGER NOT NULL, CONSTRAINT FK_B721B2FA76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B721B2FA76ED395 ON app_preference (user_id)');
        $this->addSql('CREATE UNIQUE INDEX preferences_name_user_unique ON app_preference (name, user_id)');
        $this->addSql('CREATE TABLE app_price (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, place_id INTEGER DEFAULT NULL, type VARCHAR(255) NOT NULL, value DOUBLE PRECISION NOT NULL, CONSTRAINT FK_1C1BAF14DA6A219 FOREIGN KEY (place_id) REFERENCES app_place (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_1C1BAF14DA6A219 ON app_price (place_id)');
        $this->addSql('CREATE UNIQUE INDEX prices_type_place_unique ON app_price (type, place_id)');
        $this->addSql('CREATE TABLE app_theme (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE app_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(32) DEFAULT NULL, lastname VARCHAR(32) DEFAULT NULL, mobile VARCHAR(16) DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9E7927C74 ON app_user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE app_auth_token');
        $this->addSql('DROP TABLE app_place');
        $this->addSql('DROP TABLE app_place_theme');
        $this->addSql('DROP TABLE app_preference');
        $this->addSql('DROP TABLE app_price');
        $this->addSql('DROP TABLE app_theme');
        $this->addSql('DROP TABLE app_user');
    }
}
