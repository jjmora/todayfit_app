<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220822134453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner ADD franchise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E16523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
        $this->addSql('CREATE INDEX IDX_312B3E16523CAB89 ON partner (franchise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E16523CAB89');
        $this->addSql('DROP INDEX IDX_312B3E16523CAB89 ON partner');
        $this->addSql('ALTER TABLE partner DROP franchise_id');
    }
}
