<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220508214307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image_link (id INT NOT NULL, width INT NOT NULL, height INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, provider_id INT DEFAULT NULL, url VARCHAR(350) NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(100) NOT NULL, date_creation DATETIME NOT NULL, publishing_date DATETIME NOT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_36AC99F1C54C8C93 (type_id), INDEX IDX_36AC99F1A53A8AA (provider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provider (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_link (id INT NOT NULL, width INT NOT NULL, height INT NOT NULL, duration INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image_link ADD CONSTRAINT FK_C496736FBF396750 FOREIGN KEY (id) REFERENCES link (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F1C54C8C93 FOREIGN KEY (type_id) REFERENCES link_type (id)');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F1A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id)');
        $this->addSql('ALTER TABLE video_link ADD CONSTRAINT FK_313BC42DBF396750 FOREIGN KEY (id) REFERENCES link (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_link DROP FOREIGN KEY FK_C496736FBF396750');
        $this->addSql('ALTER TABLE video_link DROP FOREIGN KEY FK_313BC42DBF396750');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F1C54C8C93');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F1A53A8AA');
        $this->addSql('DROP TABLE image_link');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE link_type');
        $this->addSql('DROP TABLE provider');
        $this->addSql('DROP TABLE video_link');
    }
}
