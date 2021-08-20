<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210819153531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_AB912789A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__Cart AS SELECT id, user_id, reference, full_name, carrier_name, carrier_price, delivery_address, is_paid, more_informations, created_at, quantity, sub_total_ht, taxe, sub_total_ttc FROM Cart');
        $this->addSql('DROP TABLE Cart');
        $this->addSql('CREATE TABLE Cart (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, reference VARCHAR(255) NOT NULL COLLATE BINARY, full_name VARCHAR(255) NOT NULL COLLATE BINARY, carrier_name VARCHAR(255) NOT NULL COLLATE BINARY, carrier_price DOUBLE PRECISION NOT NULL, delivery_address CLOB NOT NULL COLLATE BINARY, is_paid BOOLEAN NOT NULL, more_informations CLOB DEFAULT NULL COLLATE BINARY, created_at DATETIME NOT NULL, quantity INTEGER NOT NULL, sub_total_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION NOT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL, CONSTRAINT FK_AB912789A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO Cart (id, user_id, reference, full_name, carrier_name, carrier_price, delivery_address, is_paid, more_informations, created_at, quantity, sub_total_ht, taxe, sub_total_ttc) SELECT id, user_id, reference, full_name, carrier_name, carrier_price, delivery_address, is_paid, more_informations, created_at, quantity, sub_total_ht, taxe, sub_total_ttc FROM __temp__Cart');
        $this->addSql('DROP TABLE __temp__Cart');
        $this->addSql('CREATE INDEX IDX_AB912789A76ED395 ON Cart (user_id)');
        $this->addSql('DROP INDEX IDX_D4E6F81A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__address AS SELECT id, user_id, full_name, campany, address, complement, phone, city, code_postal, country FROM address');
        $this->addSql('DROP TABLE address');
        $this->addSql('CREATE TABLE address (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, full_name VARCHAR(255) NOT NULL COLLATE BINARY, campany VARCHAR(255) DEFAULT NULL COLLATE BINARY, address VARCHAR(255) NOT NULL COLLATE BINARY, complement CLOB DEFAULT NULL COLLATE BINARY, phone INTEGER NOT NULL, city VARCHAR(255) NOT NULL COLLATE BINARY, code_postal INTEGER NOT NULL, country VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_D4E6F81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO address (id, user_id, full_name, campany, address, complement, phone, city, code_postal, country) SELECT id, user_id, full_name, campany, address, complement, phone, city, code_postal, country FROM __temp__address');
        $this->addSql('DROP TABLE __temp__address');
        $this->addSql('CREATE INDEX IDX_D4E6F81A76ED395 ON address (user_id)');
        $this->addSql('DROP INDEX IDX_89FCC38DBCB5C6F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__cart_details AS SELECT id, carts_id, product_name, product_price, quantity, sub_total_ht, taxe, sub_total_ttc FROM cart_details');
        $this->addSql('DROP TABLE cart_details');
        $this->addSql('CREATE TABLE cart_details (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, carts_id INTEGER NOT NULL, product_name VARCHAR(255) NOT NULL COLLATE BINARY, product_price DOUBLE PRECISION NOT NULL, quantity INTEGER NOT NULL, sub_total_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION DEFAULT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL, CONSTRAINT FK_89FCC38DBCB5C6F5 FOREIGN KEY (carts_id) REFERENCES "Cart" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO cart_details (id, carts_id, product_name, product_price, quantity, sub_total_ht, taxe, sub_total_ttc) SELECT id, carts_id, product_name, product_price, quantity, sub_total_ht, taxe, sub_total_ttc FROM __temp__cart_details');
        $this->addSql('DROP TABLE __temp__cart_details');
        $this->addSql('CREATE INDEX IDX_89FCC38DBCB5C6F5 ON cart_details (carts_id)');
        $this->addSql('ALTER TABLE contact ADD COLUMN is_read BOOLEAN DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__order AS SELECT id, user_id, reference, full_name, carrier_name, carrier_price, delivery_address, is_paid, more_informations, created_at, quantity, sub_total_ht, taxe, sub_total_ttc, stripe_checkout_session_id FROM "order"');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('CREATE TABLE "order" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, reference VARCHAR(255) NOT NULL COLLATE BINARY, full_name VARCHAR(255) NOT NULL COLLATE BINARY, carrier_name VARCHAR(255) NOT NULL COLLATE BINARY, carrier_price DOUBLE PRECISION NOT NULL, delivery_address CLOB NOT NULL COLLATE BINARY, is_paid BOOLEAN NOT NULL, more_informations CLOB DEFAULT NULL COLLATE BINARY, created_at DATETIME NOT NULL, quantity INTEGER NOT NULL, sub_total_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION NOT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL, stripe_checkout_session_id VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "order" (id, user_id, reference, full_name, carrier_name, carrier_price, delivery_address, is_paid, more_informations, created_at, quantity, sub_total_ht, taxe, sub_total_ttc, stripe_checkout_session_id) SELECT id, user_id, reference, full_name, carrier_name, carrier_price, delivery_address, is_paid, more_informations, created_at, quantity, sub_total_ht, taxe, sub_total_ttc, stripe_checkout_session_id FROM __temp__order');
        $this->addSql('DROP TABLE __temp__order');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON "order" (user_id)');
        $this->addSql('DROP INDEX IDX_845CA2C1CFFE9AD6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__order_details AS SELECT id, orders_id, product_name, product_price, quantity, sub_total_ht, taxe, sub_total_ttc FROM order_details');
        $this->addSql('DROP TABLE order_details');
        $this->addSql('CREATE TABLE order_details (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, orders_id INTEGER NOT NULL, product_name VARCHAR(255) NOT NULL COLLATE BINARY, product_price DOUBLE PRECISION NOT NULL, quantity INTEGER NOT NULL, sub_total_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION DEFAULT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL, CONSTRAINT FK_845CA2C1CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO order_details (id, orders_id, product_name, product_price, quantity, sub_total_ht, taxe, sub_total_ttc) SELECT id, orders_id, product_name, product_price, quantity, sub_total_ht, taxe, sub_total_ttc FROM __temp__order_details');
        $this->addSql('DROP TABLE __temp__order_details');
        $this->addSql('CREATE INDEX IDX_845CA2C1CFFE9AD6 ON order_details (orders_id)');
        $this->addSql('DROP INDEX IDX_A99419434584665A');
        $this->addSql('DROP INDEX IDX_A9941943A21214B7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_categories AS SELECT product_id, categories_id FROM product_categories');
        $this->addSql('DROP TABLE product_categories');
        $this->addSql('CREATE TABLE product_categories (product_id INTEGER NOT NULL, categories_id INTEGER NOT NULL, PRIMARY KEY(product_id, categories_id), CONSTRAINT FK_A99419434584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A9941943A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product_categories (product_id, categories_id) SELECT product_id, categories_id FROM __temp__product_categories');
        $this->addSql('DROP TABLE __temp__product_categories');
        $this->addSql('CREATE INDEX IDX_A99419434584665A ON product_categories (product_id)');
        $this->addSql('CREATE INDEX IDX_A9941943A21214B7 ON product_categories (categories_id)');
        $this->addSql('DROP INDEX IDX_7CE748AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reset_password_request AS SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM reset_password_request');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('CREATE TABLE reset_password_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, selector VARCHAR(20) NOT NULL COLLATE BINARY, hashed_token VARCHAR(100) NOT NULL COLLATE BINARY, requested_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , expires_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reset_password_request (id, user_id, selector, hashed_token, requested_at, expires_at) SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM __temp__reset_password_request');
        $this->addSql('DROP TABLE __temp__reset_password_request');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('DROP INDEX IDX_E0851D6CA76ED395');
        $this->addSql('DROP INDEX IDX_E0851D6C4584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reviews_product AS SELECT id, user_id, product_id, note, comment FROM reviews_product');
        $this->addSql('DROP TABLE reviews_product');
        $this->addSql('CREATE TABLE reviews_product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, product_id INTEGER NOT NULL, note INTEGER NOT NULL, comment CLOB DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_E0851D6CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E0851D6C4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reviews_product (id, user_id, product_id, note, comment) SELECT id, user_id, product_id, note, comment FROM __temp__reviews_product');
        $this->addSql('DROP TABLE __temp__reviews_product');
        $this->addSql('CREATE INDEX IDX_E0851D6CA76ED395 ON reviews_product (user_id)');
        $this->addSql('CREATE INDEX IDX_E0851D6C4584665A ON reviews_product (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_AB912789A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__Cart AS SELECT id, user_id, reference, full_name, carrier_name, carrier_price, delivery_address, is_paid, more_informations, created_at, quantity, sub_total_ht, taxe, sub_total_ttc FROM "Cart"');
        $this->addSql('DROP TABLE "Cart"');
        $this->addSql('CREATE TABLE "Cart" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, reference VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, carrier_name VARCHAR(255) NOT NULL, carrier_price DOUBLE PRECISION NOT NULL, delivery_address CLOB NOT NULL, is_paid BOOLEAN NOT NULL, more_informations CLOB DEFAULT NULL, created_at DATETIME NOT NULL, quantity INTEGER NOT NULL, sub_total_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION NOT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO "Cart" (id, user_id, reference, full_name, carrier_name, carrier_price, delivery_address, is_paid, more_informations, created_at, quantity, sub_total_ht, taxe, sub_total_ttc) SELECT id, user_id, reference, full_name, carrier_name, carrier_price, delivery_address, is_paid, more_informations, created_at, quantity, sub_total_ht, taxe, sub_total_ttc FROM __temp__Cart');
        $this->addSql('DROP TABLE __temp__Cart');
        $this->addSql('CREATE INDEX IDX_AB912789A76ED395 ON "Cart" (user_id)');
        $this->addSql('DROP INDEX IDX_D4E6F81A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__address AS SELECT id, user_id, full_name, campany, address, complement, phone, city, code_postal, country FROM address');
        $this->addSql('DROP TABLE address');
        $this->addSql('CREATE TABLE address (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, full_name VARCHAR(255) NOT NULL, campany VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, complement CLOB DEFAULT NULL, phone INTEGER NOT NULL, city VARCHAR(255) NOT NULL, code_postal INTEGER NOT NULL, country VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO address (id, user_id, full_name, campany, address, complement, phone, city, code_postal, country) SELECT id, user_id, full_name, campany, address, complement, phone, city, code_postal, country FROM __temp__address');
        $this->addSql('DROP TABLE __temp__address');
        $this->addSql('CREATE INDEX IDX_D4E6F81A76ED395 ON address (user_id)');
        $this->addSql('DROP INDEX IDX_89FCC38DBCB5C6F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__cart_details AS SELECT id, carts_id, product_name, product_price, quantity, sub_total_ht, taxe, sub_total_ttc FROM cart_details');
        $this->addSql('DROP TABLE cart_details');
        $this->addSql('CREATE TABLE cart_details (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, carts_id INTEGER NOT NULL, product_name VARCHAR(255) NOT NULL, product_price DOUBLE PRECISION NOT NULL, quantity INTEGER NOT NULL, sub_total_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION DEFAULT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO cart_details (id, carts_id, product_name, product_price, quantity, sub_total_ht, taxe, sub_total_ttc) SELECT id, carts_id, product_name, product_price, quantity, sub_total_ht, taxe, sub_total_ttc FROM __temp__cart_details');
        $this->addSql('DROP TABLE __temp__cart_details');
        $this->addSql('CREATE INDEX IDX_89FCC38DBCB5C6F5 ON cart_details (carts_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, name, email, phone, subject, content, created_at FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, subject VARCHAR(255) NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO contact (id, name, email, phone, subject, content, created_at) SELECT id, name, email, phone, subject, content, created_at FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__order AS SELECT id, user_id, reference, full_name, carrier_name, carrier_price, delivery_address, is_paid, more_informations, created_at, quantity, sub_total_ht, taxe, sub_total_ttc, stripe_checkout_session_id FROM "order"');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('CREATE TABLE "order" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, reference VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, carrier_name VARCHAR(255) NOT NULL, carrier_price DOUBLE PRECISION NOT NULL, delivery_address CLOB NOT NULL, is_paid BOOLEAN NOT NULL, more_informations CLOB DEFAULT NULL, created_at DATETIME NOT NULL, quantity INTEGER NOT NULL, sub_total_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION NOT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL, stripe_checkout_session_id VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO "order" (id, user_id, reference, full_name, carrier_name, carrier_price, delivery_address, is_paid, more_informations, created_at, quantity, sub_total_ht, taxe, sub_total_ttc, stripe_checkout_session_id) SELECT id, user_id, reference, full_name, carrier_name, carrier_price, delivery_address, is_paid, more_informations, created_at, quantity, sub_total_ht, taxe, sub_total_ttc, stripe_checkout_session_id FROM __temp__order');
        $this->addSql('DROP TABLE __temp__order');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON "order" (user_id)');
        $this->addSql('DROP INDEX IDX_845CA2C1CFFE9AD6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__order_details AS SELECT id, orders_id, product_name, product_price, quantity, sub_total_ht, taxe, sub_total_ttc FROM order_details');
        $this->addSql('DROP TABLE order_details');
        $this->addSql('CREATE TABLE order_details (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, orders_id INTEGER NOT NULL, product_name VARCHAR(255) NOT NULL, product_price DOUBLE PRECISION NOT NULL, quantity INTEGER NOT NULL, sub_total_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION DEFAULT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO order_details (id, orders_id, product_name, product_price, quantity, sub_total_ht, taxe, sub_total_ttc) SELECT id, orders_id, product_name, product_price, quantity, sub_total_ht, taxe, sub_total_ttc FROM __temp__order_details');
        $this->addSql('DROP TABLE __temp__order_details');
        $this->addSql('CREATE INDEX IDX_845CA2C1CFFE9AD6 ON order_details (orders_id)');
        $this->addSql('DROP INDEX IDX_A99419434584665A');
        $this->addSql('DROP INDEX IDX_A9941943A21214B7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_categories AS SELECT product_id, categories_id FROM product_categories');
        $this->addSql('DROP TABLE product_categories');
        $this->addSql('CREATE TABLE product_categories (product_id INTEGER NOT NULL, categories_id INTEGER NOT NULL, PRIMARY KEY(product_id, categories_id))');
        $this->addSql('INSERT INTO product_categories (product_id, categories_id) SELECT product_id, categories_id FROM __temp__product_categories');
        $this->addSql('DROP TABLE __temp__product_categories');
        $this->addSql('CREATE INDEX IDX_A99419434584665A ON product_categories (product_id)');
        $this->addSql('CREATE INDEX IDX_A9941943A21214B7 ON product_categories (categories_id)');
        $this->addSql('DROP INDEX IDX_7CE748AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reset_password_request AS SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM reset_password_request');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('CREATE TABLE reset_password_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , expires_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO reset_password_request (id, user_id, selector, hashed_token, requested_at, expires_at) SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM __temp__reset_password_request');
        $this->addSql('DROP TABLE __temp__reset_password_request');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('DROP INDEX IDX_E0851D6CA76ED395');
        $this->addSql('DROP INDEX IDX_E0851D6C4584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reviews_product AS SELECT id, user_id, product_id, note, comment FROM reviews_product');
        $this->addSql('DROP TABLE reviews_product');
        $this->addSql('CREATE TABLE reviews_product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, product_id INTEGER NOT NULL, note INTEGER NOT NULL, comment CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO reviews_product (id, user_id, product_id, note, comment) SELECT id, user_id, product_id, note, comment FROM __temp__reviews_product');
        $this->addSql('DROP TABLE __temp__reviews_product');
        $this->addSql('CREATE INDEX IDX_E0851D6CA76ED395 ON reviews_product (user_id)');
        $this->addSql('CREATE INDEX IDX_E0851D6C4584665A ON reviews_product (product_id)');
    }
}
