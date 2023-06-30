<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230630182029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_library (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, library_id INT NOT NULL, rented TINYINT(1) NOT NULL, INDEX IDX_32A0B02A16A2B381 (book_id), INDEX IDX_32A0B02AFE2541D7 (library_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_library ADD CONSTRAINT FK_32A0B02A16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book_library ADD CONSTRAINT FK_32A0B02AFE2541D7 FOREIGN KEY (library_id) REFERENCES library (id)');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331FE2541D7');
        $this->addSql('DROP INDEX IDX_CBE5A331FE2541D7 ON book');
        $this->addSql('ALTER TABLE book DROP library_id, DROP rented');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_library DROP FOREIGN KEY FK_32A0B02A16A2B381');
        $this->addSql('ALTER TABLE book_library DROP FOREIGN KEY FK_32A0B02AFE2541D7');
        $this->addSql('DROP TABLE book_library');
        $this->addSql('ALTER TABLE book ADD library_id INT NOT NULL, ADD rented TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331FE2541D7 FOREIGN KEY (library_id) REFERENCES library (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_CBE5A331FE2541D7 ON book (library_id)');
    }
}
