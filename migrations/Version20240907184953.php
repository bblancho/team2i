<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240907184953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE offres ADD societes_id INT NOT NULL');
        // $this->addSql('ALTER TABLE offres ADD CONSTRAINT FK_C6AC35447E841BEA FOREIGN KEY (societes_id) REFERENCES societes (id)');
        // $this->addSql('CREATE INDEX IDX_C6AC35447E841BEA ON offres (societes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offres DROP FOREIGN KEY FK_C6AC35447E841BEA');
        $this->addSql('DROP INDEX IDX_C6AC35447E841BEA ON offres');
        $this->addSql('ALTER TABLE offres DROP societes_id');
    }
}
