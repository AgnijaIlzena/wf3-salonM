<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622133354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation ADD payement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955868C0609 FOREIGN KEY (payement_id) REFERENCES payement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C84955868C0609 ON reservation (payement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955868C0609');
        $this->addSql('DROP INDEX UNIQ_42C84955868C0609 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP payement_id');
    }
}
