<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151122021131 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_quantity DROP FOREIGN KEY FK_F3FEDEFD126F525E');
        $this->addSql('ALTER TABLE item_quantity DROP FOREIGN KEY FK_F3FEDEFDC86F3B2F');
        $this->addSql('ALTER TABLE item_quantity ADD CONSTRAINT FK_F3FEDEFD126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_quantity ADD CONSTRAINT FK_F3FEDEFDC86F3B2F FOREIGN KEY (week_id) REFERENCES week (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_quantity DROP FOREIGN KEY FK_F3FEDEFD126F525E');
        $this->addSql('ALTER TABLE item_quantity DROP FOREIGN KEY FK_F3FEDEFDC86F3B2F');
        $this->addSql('ALTER TABLE item_quantity ADD CONSTRAINT FK_F3FEDEFD126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE item_quantity ADD CONSTRAINT FK_F3FEDEFDC86F3B2F FOREIGN KEY (week_id) REFERENCES week (id)');
    }
}
