<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125190603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add initial data.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            INSERT status(name, shop_count, product_count)
            VALUES
                ('BANNED', 0, 0),
                ('COMMON', 1, 10),
                ('VIP', 3, 20),
                ('PREMIUM', 5, 30)"
        );
        $this->addSql("
            INSERT category(name)
            VALUES
                ('Clothes'),
                ('Games'),
                ('Technic'),
                ('Building')"
        );
    }

    public function down(Schema $schema): void
    {}
}