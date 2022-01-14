<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220114085412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE combat ADD CONSTRAINT FK_8D51E3982D521FDF FOREIGN KEY (challenger_id) REFERENCES characters (id)');
        $this->addSql('CREATE INDEX IDX_8D51E3982D521FDF ON combat (challenger_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE combat DROP FOREIGN KEY FK_8D51E3982D521FDF');
        $this->addSql('DROP INDEX IDX_8D51E3982D521FDF ON combat');
    }
}
