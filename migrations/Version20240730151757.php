<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240730151757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('CREATE TABLE missions (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, nom VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(100) NOT NULL, tarif INT DEFAULT NULL, start_date_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', duree INT NOT NULL, is_pourvue TINYINT(1) NOT NULL, lieu_mission VARCHAR(100) NOT NULL, is_active TINYINT(1) NOT NULL, experience INT NOT NULL, INDEX IDX_34F1D47E67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE missions_skills (missions_id INT NOT NULL, skills_id INT NOT NULL, INDEX IDX_13E712A717C042CF (missions_id), INDEX IDX_13E712A77FF61858 (skills_id), PRIMARY KEY(missions_id, skills_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE skills (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, nom VARCHAR(50) NOT NULL, slug VARCHAR(60) NOT NULL, INDEX IDX_D531167067B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, adresse VARCHAR(255) NOT NULL, cp INT NOT NULL, ville VARCHAR(255) NOT NULL, phone VARCHAR(20) NOT NULL, type_user VARCHAR(50) NOT NULL, nom_contact VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, phone_contact VARCHAR(50) DEFAULT NULL, dispo TINYINT(1) DEFAULT NULL, date_dispo_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', tjm INT DEFAULT NULL, siret VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, secteur_activite VARCHAR(255) DEFAULT NULL, is_nesletter TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47E67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        // $this->addSql('ALTER TABLE missions_skills ADD CONSTRAINT FK_13E712A717C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        // $this->addSql('ALTER TABLE missions_skills ADD CONSTRAINT FK_13E712A77FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE');
        // $this->addSql('ALTER TABLE skills ADD CONSTRAINT FK_D531167067B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE missions DROP FOREIGN KEY FK_34F1D47E67B3B43D');
        $this->addSql('ALTER TABLE missions_skills DROP FOREIGN KEY FK_13E712A717C042CF');
        $this->addSql('ALTER TABLE missions_skills DROP FOREIGN KEY FK_13E712A77FF61858');
        $this->addSql('ALTER TABLE skills DROP FOREIGN KEY FK_D531167067B3B43D');
        $this->addSql('DROP TABLE missions');
        $this->addSql('DROP TABLE missions_skills');
        $this->addSql('DROP TABLE skills');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
