<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230709120043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice ADD sales_rep_id INT NOT NULL, ADD start_date DATETIME NOT NULL, ADD end_date DATETIME NOT NULL, DROP start, DROP end');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_9065174476311BE2 FOREIGN KEY (sales_rep_id) REFERENCES sales_rep (id)');
        $this->addSql('CREATE INDEX IDX_9065174476311BE2 ON invoice (sales_rep_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_9065174476311BE2');
        $this->addSql('DROP INDEX IDX_9065174476311BE2 ON invoice');
        $this->addSql('ALTER TABLE invoice ADD start DATETIME NOT NULL, ADD end DATETIME NOT NULL, DROP sales_rep_id, DROP start_date, DROP end_date');
    }
}
