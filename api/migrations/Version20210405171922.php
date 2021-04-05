<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210405171922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student_marks CHANGE approach_number approach_number INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student_subject CHANGE student_subject_id student_subject_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE subject CHANGE type type VARCHAR(20) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE teacher_class CHANGE teacher_class_id teacher_class_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE teacher_subject CHANGE teacher_subject_id teacher_subject_id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student_marks CHANGE approach_number approach_number INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student_subject CHANGE student_subject_id student_subject_id INT NOT NULL');
        $this->addSql('ALTER TABLE subject CHANGE type type VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE teacher_class CHANGE teacher_class_id teacher_class_id INT NOT NULL');
        $this->addSql('ALTER TABLE teacher_subject CHANGE teacher_subject_id teacher_subject_id INT NOT NULL');
    }
}
