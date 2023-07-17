<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230713120802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_E98F2859AEA34913 ON contract');
        $this->addSql('ALTER TABLE contract CHANGE reference number VARCHAR(20) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E98F285996901F54 ON contract (number)');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_9065174419EB6921');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_9065174476311BE2');
        $this->addSql('DROP INDEX IDX_9065174419EB6921 ON invoice');
        $this->addSql('DROP INDEX IDX_9065174476311BE2 ON invoice');
        $this->addSql('ALTER TABLE invoice ADD contract_id INT NOT NULL, DROP client_id, DROP sales_rep_id, DROP price, DROP start_date, DROP end_date');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517442576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_906517442576E0FD ON invoice (contract_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_E98F285996901F54 ON contract');
        $this->addSql('ALTER TABLE contract CHANGE number reference VARCHAR(20) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E98F2859AEA34913 ON contract (reference)');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517442576E0FD');
        $this->addSql('DROP INDEX UNIQ_906517442576E0FD ON invoice');
        $this->addSql('ALTER TABLE invoice ADD sales_rep_id INT NOT NULL, ADD price NUMERIC(10, 0) NOT NULL, ADD start_date DATETIME NOT NULL, ADD end_date DATETIME NOT NULL, CHANGE contract_id client_id INT NOT NULL');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_9065174419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_9065174476311BE2 FOREIGN KEY (sales_rep_id) REFERENCES sales_rep (id)');
        $this->addSql('CREATE INDEX IDX_9065174419EB6921 ON invoice (client_id)');
        $this->addSql('CREATE INDEX IDX_9065174476311BE2 ON invoice (sales_rep_id)');
    }
}
