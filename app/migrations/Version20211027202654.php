<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211027202654 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE exercise_classifier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4E3AE975E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercise_plan ADD name_id INT NOT NULL, DROP name');
        $this->addSql('ALTER TABLE exercise_plan ADD CONSTRAINT FK_847F39CF71179CD6 FOREIGN KEY (name_id) REFERENCES exercise_classifier (id)');
        $this->addSql('CREATE INDEX IDX_847F39CF71179CD6 ON exercise_plan (name_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE exercise_plan DROP FOREIGN KEY FK_847F39CF71179CD6');
        $this->addSql('DROP TABLE exercise_classifier');
        $this->addSql('DROP INDEX IDX_847F39CF71179CD6 ON exercise_plan');
        $this->addSql('ALTER TABLE exercise_plan ADD name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP name_id');
    }
}
