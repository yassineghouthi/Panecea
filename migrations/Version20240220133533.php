<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220133533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hopital_image DROP FOREIGN KEY FK_D14D9C8CCC0FBF92');
        $this->addSql('ALTER TABLE hopital_image ADD CONSTRAINT FK_D14D9C8CCC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955D3B748BE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955578B7FBD');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955D3B748BE FOREIGN KEY (user_reservation_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955578B7FBD FOREIGN KEY (urgence_id) REFERENCES urgence (id)');
        $this->addSql('ALTER TABLE urgence DROP FOREIGN KEY FK_737D6BCDCC0FBF92');
        $this->addSql('ALTER TABLE urgence ADD CONSTRAINT FK_737D6BCDCC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hopital_image DROP FOREIGN KEY FK_D14D9C8CCC0FBF92');
        $this->addSql('ALTER TABLE hopital_image ADD CONSTRAINT FK_D14D9C8CCC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955D3B748BE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955578B7FBD');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955D3B748BE FOREIGN KEY (user_reservation_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955578B7FBD FOREIGN KEY (urgence_id) REFERENCES urgence (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE urgence DROP FOREIGN KEY FK_737D6BCDCC0FBF92');
        $this->addSql('ALTER TABLE urgence ADD CONSTRAINT FK_737D6BCDCC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
