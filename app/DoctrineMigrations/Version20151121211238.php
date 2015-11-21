<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151121211238 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_quantity ADD item_id INT NOT NULL');
        $this->addSql('ALTER TABLE item_quantity ADD CONSTRAINT FK_F3FEDEFD126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('CREATE INDEX IDX_F3FEDEFD126F525E ON item_quantity (item_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_quantity DROP FOREIGN KEY FK_F3FEDEFD126F525E');
        $this->addSql('DROP INDEX IDX_F3FEDEFD126F525E ON item_quantity');
        $this->addSql('ALTER TABLE item_quantity DROP item_id');
    }
}
