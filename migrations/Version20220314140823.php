<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220314140823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation ADD idniveau_id INT NOT NULL');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF75253574 FOREIGN KEY (idniveau_id) REFERENCES niveaux (id)');
        $this->addSql('CREATE INDEX IDX_404021BF75253574 ON formation (idniveau_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF75253574');
        $this->addSql('DROP INDEX IDX_404021BF75253574 ON formation');
        $this->addSql('ALTER TABLE formation DROP idniveau_id');
    }
}
