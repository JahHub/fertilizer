<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151122014738 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_quantity DROP FOREIGN KEY FK_F3FEDEFDC86F3B2F');
        $this->addSql('ALTER TABLE item_quantity ADD CONSTRAINT FK_F3FEDEFDC86F3B2F FOREIGN KEY (week_id) REFERENCES week (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE week ADD state_id INT NOT NULL');
        $this->addSql('ALTER TABLE week ADD CONSTRAINT FK_5B5A69C05D83CC1 FOREIGN KEY (state_id) REFERENCES state (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_5B5A69C05D83CC1 ON week (state_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_quantity DROP FOREIGN KEY FK_F3FEDEFDC86F3B2F');
        $this->addSql('ALTER TABLE item_quantity ADD CONSTRAINT FK_F3FEDEFDC86F3B2F FOREIGN KEY (week_id) REFERENCES week (id)');
        $this->addSql('ALTER TABLE week DROP FOREIGN KEY FK_5B5A69C05D83CC1');
        $this->addSql('DROP INDEX IDX_5B5A69C05D83CC1 ON week');
        $this->addSql('ALTER TABLE week DROP state_id');
    }
}
