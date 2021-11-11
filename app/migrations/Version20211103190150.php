<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211103190150 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE goal_user ADD c_values LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD units LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE program ADD goal_id INT NOT NULL');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED7784667D1AFE FOREIGN KEY (goal_id) REFERENCES goal_user (id)');
        $this->addSql('CREATE INDEX IDX_92ED7784667D1AFE ON program (goal_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE goal_user DROP c_values, DROP units');
        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED7784667D1AFE');
        $this->addSql('DROP INDEX IDX_92ED7784667D1AFE ON program');
        $this->addSql('ALTER TABLE program DROP goal_id');
    }
}
