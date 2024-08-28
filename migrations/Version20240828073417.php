<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240828073417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE materials (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, price INTEGER NOT NULL, amount INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE "order" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fist_name VARCHAR(30) NOT NULL, last_name VARCHAR(30) NOT NULL, price INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE order_materials (order_id INTEGER NOT NULL, materials_id INTEGER NOT NULL, PRIMARY KEY(order_id, materials_id), CONSTRAINT FK_27906D4D8D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_27906D4D3A9FC940 FOREIGN KEY (materials_id) REFERENCES materials (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_27906D4D8D9F6D38 ON order_materials (order_id)');
        $this->addSql('CREATE INDEX IDX_27906D4D3A9FC940 ON order_materials (materials_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE materials');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE order_materials');
    }
}
