<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240827073551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clients (id INT NOT NULL, tjm INT NOT NULL, dispo TINYINT(1) DEFAULT NULL, date_dispo_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE societes (id INT NOT NULL, nom_contact VARCHAR(255) DEFAULT NULL, num_contact VARCHAR(50) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, secteur_activite VARCHAR(255) DEFAULT NULL, phone_contact VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clients ADD CONSTRAINT FK_C82E74BF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE societes ADD CONSTRAINT FK_AEC76507BF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions ADD societes_id INT NOT NULL, DROP nb_personnes');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47E7E841BEA FOREIGN KEY (societes_id) REFERENCES societes (id)');
        $this->addSql('CREATE INDEX IDX_34F1D47E7E841BEA ON missions (societes_id)');
        $this->addSql('ALTER TABLE users ADD discr VARCHAR(255) NOT NULL, DROP nom_contact, DROP description, DROP phone_contact, DROP dispo, DROP tjm, DROP secteur_activite, DROP image_name, CHANGE date_dispo_at date_inscription_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE missions DROP FOREIGN KEY FK_34F1D47E7E841BEA');
        $this->addSql('ALTER TABLE clients DROP FOREIGN KEY FK_C82E74BF396750');
        $this->addSql('ALTER TABLE societes DROP FOREIGN KEY FK_AEC76507BF396750');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE societes');
        $this->addSql('ALTER TABLE users ADD nom_contact VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, ADD phone_contact VARCHAR(50) DEFAULT NULL, ADD dispo TINYINT(1) DEFAULT NULL, ADD tjm INT DEFAULT NULL, ADD secteur_activite VARCHAR(255) DEFAULT NULL, ADD image_name VARCHAR(255) DEFAULT NULL, DROP discr, CHANGE date_inscription_at date_dispo_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP INDEX IDX_34F1D47E7E841BEA ON missions');
        $this->addSql('ALTER TABLE missions ADD nb_personnes INT DEFAULT NULL, DROP societes_id');
    }
}
