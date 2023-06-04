<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601174838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acceuil ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE acceuil ADD CONSTRAINT FK_4EA6B851A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4EA6B851A76ED395 ON acceuil (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acceuil DROP FOREIGN KEY FK_4EA6B851A76ED395');
        $this->addSql('DROP INDEX UNIQ_4EA6B851A76ED395 ON acceuil');
        $this->addSql('ALTER TABLE acceuil DROP user_id');
    }
}
