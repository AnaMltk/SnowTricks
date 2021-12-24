<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211224133923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, figure_id INT DEFAULT NULL, creation_date DATETIME NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526C5C011B5 (figure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE figure (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, group_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, creation_date DATETIME NOT NULL, modification_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_2F57B37A5E237E06 (name), INDEX IDX_2F57B37AA76ED395 (user_id), INDEX IDX_2F57B37AFE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, figure_id INT DEFAULT NULL, creation_date DATETIME NOT NULL, path VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, INDEX IDX_14B784185C011B5 (figure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, figure_id INT DEFAULT NULL, creation_date DATETIME NOT NULL, link VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, INDEX IDX_7CC7DA2C5C011B5 (figure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37AFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784185C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C5C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5C011B5');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784185C011B5');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C5C011B5');
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37AFE54D947');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37AA76ED395');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE figure');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE video');
    }
}
