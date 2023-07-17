<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230713124614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517442576E0FD');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517442576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517442576E0FD');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517442576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
    }
}
