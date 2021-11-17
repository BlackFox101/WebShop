<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117205714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (category_id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop (shop_id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_hidden TINYINT(1) DEFAULT 0, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP NULL, PRIMARY KEY(shop_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_item (shop_item_id INT AUTO_INCREMENT NOT NULL, shop_id INT DEFAULT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, is_hidden TINYINT(1) DEFAULT 0, price NUMERIC(10, 2) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP NULL, INDEX IDX_DEE9C3654D16C4DD (shop_id), INDEX IDX_DEE9C36512469DE2 (category_id), PRIMARY KEY(shop_item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_item_image (shop_item_image_id INT AUTO_INCREMENT NOT NULL, shop_item_id INT NOT NULL, image_path VARCHAR(255) NOT NULL, INDEX IDX_95E9F2A9115C1274 (shop_item_id), PRIMARY KEY(shop_item_image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (status_id INT AUTO_INCREMENT NOT NULL, shop_count INT NOT NULL, shop_item_count INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(status_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (user_id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, login VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, phone VARCHAR(50) NOT NULL, roles JSON NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), UNIQUE INDEX UNIQ_8D93D649444F97DD (phone), INDEX IDX_8D93D6496BF700BD (status_id), PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_favourites_items (user_id INT NOT NULL, shop_item_id INT NOT NULL, INDEX IDX_5394A9AEA76ED395 (user_id), UNIQUE INDEX UNIQ_5394A9AE115C1274 (shop_item_id), PRIMARY KEY(user_id, shop_item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop_item ADD CONSTRAINT FK_DEE9C3654D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (shop_id)');
        $this->addSql('ALTER TABLE shop_item ADD CONSTRAINT FK_DEE9C36512469DE2 FOREIGN KEY (category_id) REFERENCES category (category_id)');
        $this->addSql('ALTER TABLE shop_item_image ADD CONSTRAINT FK_95E9F2A9115C1274 FOREIGN KEY (shop_item_id) REFERENCES shop_item (shop_item_id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496BF700BD FOREIGN KEY (status_id) REFERENCES status (status_id)');
        $this->addSql('ALTER TABLE users_favourites_items ADD CONSTRAINT FK_5394A9AEA76ED395 FOREIGN KEY (user_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE users_favourites_items ADD CONSTRAINT FK_5394A9AE115C1274 FOREIGN KEY (shop_item_id) REFERENCES shop_item (shop_item_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop_item DROP FOREIGN KEY FK_DEE9C36512469DE2');
        $this->addSql('ALTER TABLE shop_item DROP FOREIGN KEY FK_DEE9C3654D16C4DD');
        $this->addSql('ALTER TABLE shop_item_image DROP FOREIGN KEY FK_95E9F2A9115C1274');
        $this->addSql('ALTER TABLE users_favourites_items DROP FOREIGN KEY FK_5394A9AE115C1274');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496BF700BD');
        $this->addSql('ALTER TABLE users_favourites_items DROP FOREIGN KEY FK_5394A9AEA76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE shop_item');
        $this->addSql('DROP TABLE shop_item_image');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE users_favourites_items');
    }
}
