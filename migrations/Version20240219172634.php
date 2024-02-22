<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219172634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hopital (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, localisation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hopital_image (id INT AUTO_INCREMENT NOT NULL, hopital_id INT DEFAULT NULL, image_url VARCHAR(255) NOT NULL, INDEX IDX_D14D9C8CCC0FBF92 (hopital_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, user_reservation_id INT DEFAULT NULL, urgence_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, date DATETIME NOT NULL, INDEX IDX_42C84955D3B748BE (user_reservation_id), INDEX IDX_42C84955578B7FBD (urgence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE urgence (id INT AUTO_INCREMENT NOT NULL, hopital_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, nombre_lit INT NOT NULL, specialite VARCHAR(255) NOT NULL, nombre_lit_disponible INT NOT NULL, UNIQUE INDEX UNIQ_737D6BCDCC0FBF92 (hopital_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hopital_image ADD CONSTRAINT FK_D14D9C8CCC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955D3B748BE FOREIGN KEY (user_reservation_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955578B7FBD FOREIGN KEY (urgence_id) REFERENCES urgence (id)');
        $this->addSql('ALTER TABLE urgence ADD CONSTRAINT FK_737D6BCDCC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hopital_image DROP FOREIGN KEY FK_D14D9C8CCC0FBF92');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955D3B748BE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955578B7FBD');
        $this->addSql('ALTER TABLE urgence DROP FOREIGN KEY FK_737D6BCDCC0FBF92');
        $this->addSql('DROP TABLE hopital');
        $this->addSql('DROP TABLE hopital_image');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE urgence');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
