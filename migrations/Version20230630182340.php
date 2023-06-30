<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230630182340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_library DROP FOREIGN KEY FK_32A0B02AFE2541D7');
        $this->addSql('ALTER TABLE book_library DROP FOREIGN KEY FK_32A0B02A16A2B381');
        $this->addSql('ALTER TABLE book_library ADD CONSTRAINT FK_32A0B02AFE2541D7 FOREIGN KEY (library_id) REFERENCES library (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_library ADD CONSTRAINT FK_32A0B02A16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_library DROP FOREIGN KEY FK_32A0B02A16A2B381');
        $this->addSql('ALTER TABLE book_library DROP FOREIGN KEY FK_32A0B02AFE2541D7');
        $this->addSql('ALTER TABLE book_library ADD CONSTRAINT FK_32A0B02A16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book_library ADD CONSTRAINT FK_32A0B02AFE2541D7 FOREIGN KEY (library_id) REFERENCES library (id)');
    }
}
