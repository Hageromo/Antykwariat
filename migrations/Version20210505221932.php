<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210505221932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE my_collection_attribute ADD attribute_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE my_collection_attribute ADD CONSTRAINT FK_8BC3942FB6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('CREATE INDEX IDX_8BC3942FB6E62EFA ON my_collection_attribute (attribute_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE my_collection_attribute DROP FOREIGN KEY FK_8BC3942FB6E62EFA');
        $this->addSql('DROP INDEX IDX_8BC3942FB6E62EFA ON my_collection_attribute');
        $this->addSql('ALTER TABLE my_collection_attribute DROP attribute_id');
    }
}
