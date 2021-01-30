<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126002516 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'posts_votes table creation';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(
            'CREATE TABLE `posts_votes` (
                  `id` varchar(36) NOT NULL,
                  `createdBy` varchar (36) NOT NULL COMMENT \'User which set a vote\',
                  `postId` varchar(36) NOT NULL COMMENT \'Post id\',
                  `isNegative` tinyint(1) NOT NULL DEFAULT 0 COMMENT \'Is vote negative\',
                  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'Date of creation\',
                  UNIQUE KEY `UQ_CreatedBy_PostId` (`createdBy`, `postId`),
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT=\'Posts votes table\';'
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE `posts_votes`');
    }
}
