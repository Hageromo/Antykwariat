<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210505221258 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribute_object (id INT AUTO_INCREMENT NOT NULL, collection_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_8A4C85B6514956FD (collection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE my_collection_attribute (id INT AUTO_INCREMENT NOT NULL, my_collection_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_8BC3942F833C265C (my_collection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribute_object ADD CONSTRAINT FK_8A4C85B6514956FD FOREIGN KEY (collection_id) REFERENCES my_collection (id)');
        $this->addSql('ALTER TABLE my_collection_attribute ADD CONSTRAINT FK_8BC3942F833C265C FOREIGN KEY (my_collection_id) REFERENCES my_collection (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE attribute_object');
        $this->addSql('DROP TABLE my_collection_attribute');
    }
}
