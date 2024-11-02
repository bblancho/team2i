<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240913131054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE offres CHANGE start_date_at start_date_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE duree duree INT NOT NULL, CHANGE lieu_mission lieu_mission VARCHAR(100) NOT NULL, CHANGE experience experience INT NOT NULL');
        // $this->addSql('ALTER TABLE offres_skills DROP FOREIGN KEY FK_2E00F5CA6C83CD9F');
        // $this->addSql('ALTER TABLE offres_skills ADD CONSTRAINT FK_2E00F5CA6C83CD9F FOREIGN KEY (offres_id) REFERENCES offres (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offres CHANGE start_date_at start_date_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE duree duree INT DEFAULT NULL, CHANGE lieu_mission lieu_mission VARCHAR(100) DEFAULT NULL, CHANGE experience experience INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offres_skills DROP FOREIGN KEY FK_2E00F5CA6C83CD9F');
        $this->addSql('ALTER TABLE offres_skills ADD CONSTRAINT FK_2E00F5CA6C83CD9F FOREIGN KEY (offres_id) REFERENCES offres (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
