<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251006153331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author ADD classroom_ref INT DEFAULT NULL');
        $this->addSql('ALTER TABLE author ADD CONSTRAINT FK_BDAFD8C8A7D4053F FOREIGN KEY (classroom_ref) REFERENCES classroom (ref)');
        $this->addSql('CREATE INDEX IDX_BDAFD8C8A7D4053F ON author (classroom_ref)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author DROP FOREIGN KEY FK_BDAFD8C8A7D4053F');
        $this->addSql('DROP INDEX IDX_BDAFD8C8A7D4053F ON author');
        $this->addSql('ALTER TABLE author DROP classroom_ref');
    }
}
