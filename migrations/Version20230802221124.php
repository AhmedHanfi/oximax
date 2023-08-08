<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230802221124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE docteur_patient_ligne (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, docteur_id INT DEFAULT NULL, INDEX IDX_59D6F1EB6B899279 (patient_id), INDEX IDX_59D6F1EBCF22540A (docteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE docteur_patient_ligne ADD CONSTRAINT FK_59D6F1EB6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE docteur_patient_ligne ADD CONSTRAINT FK_59D6F1EBCF22540A FOREIGN KEY (docteur_id) REFERENCES docteur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE docteur_patient_ligne DROP FOREIGN KEY FK_59D6F1EB6B899279');
        $this->addSql('ALTER TABLE docteur_patient_ligne DROP FOREIGN KEY FK_59D6F1EBCF22540A');
        $this->addSql('DROP TABLE docteur_patient_ligne');
    }
}
