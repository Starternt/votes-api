<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210213131606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create users view';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE VIEW `votes`.`users` AS SELECT * FROM `users`.`users`;');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP VIEW `votes`.`users`;');
    }
}
