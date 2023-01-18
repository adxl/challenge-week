<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117214140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE greeting_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE deliverer_review_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_review_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE deliverer_review (id INT NOT NULL, product_order_id INT NOT NULL, rating INT DEFAULT NULL, comment TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A2E91F79462F07AF ON deliverer_review (product_order_id)');
        $this->addSql('CREATE TABLE product_review (id INT NOT NULL, product_id INT NOT NULL, product_order_id INT NOT NULL, rating BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1B3FC0624584665A ON product_review (product_id)');
        $this->addSql('CREATE INDEX IDX_1B3FC062462F07AF ON product_review (product_order_id)');
        $this->addSql('ALTER TABLE deliverer_review ADD CONSTRAINT FK_A2E91F79462F07AF FOREIGN KEY (product_order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_review ADD CONSTRAINT FK_1B3FC0624584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_review ADD CONSTRAINT FK_1B3FC062462F07AF FOREIGN KEY (product_order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE greeting');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE deliverer_review_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_review_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE greeting_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE greeting (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE deliverer_review DROP CONSTRAINT FK_A2E91F79462F07AF');
        $this->addSql('ALTER TABLE product_review DROP CONSTRAINT FK_1B3FC0624584665A');
        $this->addSql('ALTER TABLE product_review DROP CONSTRAINT FK_1B3FC062462F07AF');
        $this->addSql('DROP TABLE deliverer_review');
        $this->addSql('DROP TABLE product_review');
    }
}
