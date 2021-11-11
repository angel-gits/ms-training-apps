<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211020173450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE exercise (id INT AUTO_INCREMENT NOT NULL, exercise_plan_id INT NOT NULL, training_id INT NOT NULL, weight DOUBLE PRECISION DEFAULT NULL, repetition_num INT DEFAULT NULL, time_limit INT DEFAULT NULL, INDEX IDX_AEDAD51C328CF5DE (exercise_plan_id), INDEX IDX_AEDAD51CBEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercise_plan (id INT AUTO_INCREMENT NOT NULL, training_plan_id INT NOT NULL, goal_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, sets_num INT NOT NULL, INDEX IDX_847F39CF35A79295 (training_plan_id), INDEX IDX_847F39CF667D1AFE (goal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE goal (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, user_id INT NOT NULL, id_done TINYINT(1) NOT NULL, criteria LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, program_plan_id INT NOT NULL, owner_id INT NOT NULL, trainers_id LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', start_date_time DATETIME NOT NULL, finish_date_time DATETIME NOT NULL, INDEX IDX_92ED77846373FA4F (program_plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_plan (id INT AUTO_INCREMENT NOT NULL, goal_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, authors_id LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', duration INT NOT NULL, INDEX IDX_D0BC0E7A667D1AFE (goal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistics (id INT AUTO_INCREMENT NOT NULL, exersice_name VARCHAR(255) NOT NULL, dates LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', weight DOUBLE PRECISION DEFAULT NULL, time INT DEFAULT NULL, repetition_num INT DEFAULT NULL, user_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, training_plan_id INT NOT NULL, program_id INT NOT NULL, start_date_time DATETIME NOT NULL, finish_date_time DATETIME DEFAULT NULL, status SMALLINT NOT NULL, INDEX IDX_D5128A8F35A79295 (training_plan_id), INDEX IDX_D5128A8F3EB8070A (program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_plan (id INT AUTO_INCREMENT NOT NULL, program_plan_id INT DEFAULT NULL, goal_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_D2C01C3E6373FA4F (program_plan_id), INDEX IDX_D2C01C3E667D1AFE (goal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT FK_AEDAD51C328CF5DE FOREIGN KEY (exercise_plan_id) REFERENCES exercise_plan (id)');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT FK_AEDAD51CBEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('ALTER TABLE exercise_plan ADD CONSTRAINT FK_847F39CF35A79295 FOREIGN KEY (training_plan_id) REFERENCES training_plan (id)');
        $this->addSql('ALTER TABLE exercise_plan ADD CONSTRAINT FK_847F39CF667D1AFE FOREIGN KEY (goal_id) REFERENCES goal (id)');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED77846373FA4F FOREIGN KEY (program_plan_id) REFERENCES program_plan (id)');
        $this->addSql('ALTER TABLE program_plan ADD CONSTRAINT FK_D0BC0E7A667D1AFE FOREIGN KEY (goal_id) REFERENCES goal (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F35A79295 FOREIGN KEY (training_plan_id) REFERENCES training_plan (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F3EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE training_plan ADD CONSTRAINT FK_D2C01C3E6373FA4F FOREIGN KEY (program_plan_id) REFERENCES program_plan (id)');
        $this->addSql('ALTER TABLE training_plan ADD CONSTRAINT FK_D2C01C3E667D1AFE FOREIGN KEY (goal_id) REFERENCES goal (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE exercise DROP FOREIGN KEY FK_AEDAD51C328CF5DE');
        $this->addSql('ALTER TABLE exercise_plan DROP FOREIGN KEY FK_847F39CF667D1AFE');
        $this->addSql('ALTER TABLE program_plan DROP FOREIGN KEY FK_D0BC0E7A667D1AFE');
        $this->addSql('ALTER TABLE training_plan DROP FOREIGN KEY FK_D2C01C3E667D1AFE');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F3EB8070A');
        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED77846373FA4F');
        $this->addSql('ALTER TABLE training_plan DROP FOREIGN KEY FK_D2C01C3E6373FA4F');
        $this->addSql('ALTER TABLE exercise DROP FOREIGN KEY FK_AEDAD51CBEFD98D1');
        $this->addSql('ALTER TABLE exercise_plan DROP FOREIGN KEY FK_847F39CF35A79295');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F35A79295');
        $this->addSql('DROP TABLE exercise');
        $this->addSql('DROP TABLE exercise_plan');
        $this->addSql('DROP TABLE goal');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE program_plan');
        $this->addSql('DROP TABLE statistics');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE training_plan');
    }
}
