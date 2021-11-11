<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211021032244 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE goal_user ADD goal_id INT NOT NULL, DROP name');
        $this->addSql('ALTER TABLE goal_user ADD CONSTRAINT FK_93A393EB667D1AFE FOREIGN KEY (goal_id) REFERENCES goal (id)');
        $this->addSql('CREATE INDEX IDX_93A393EB667D1AFE ON goal_user (goal_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE goal_user DROP FOREIGN KEY FK_93A393EB667D1AFE');
        $this->addSql('DROP INDEX IDX_93A393EB667D1AFE ON goal_user');
        $this->addSql('ALTER TABLE goal_user ADD name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP goal_id');
    }
}
