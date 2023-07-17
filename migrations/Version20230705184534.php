<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705184534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contract ADD sales_rep_id INT NOT NULL');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F285976311BE2 FOREIGN KEY (sales_rep_id) REFERENCES sales_rep (id)');
        $this->addSql('CREATE INDEX IDX_E98F285976311BE2 ON contract (sales_rep_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F285976311BE2');
        $this->addSql('DROP INDEX IDX_E98F285976311BE2 ON contract');
        $this->addSql('ALTER TABLE contract DROP sales_rep_id');
    }
}
