<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190618163408 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, phone VARCHAR(100) DEFAULT NULL, INDEX IDX_CD1DE18A64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department_department (department_source INT NOT NULL, department_target INT NOT NULL, INDEX IDX_5F14ED664B908083 (department_source), INDEX IDX_5F14ED665275D00C (department_target), PRIMARY KEY(department_source, department_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, address_street1 VARCHAR(255) NOT NULL, city VARCHAR(100) NOT NULL, state VARCHAR(2) NOT NULL, zip VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, display_name VARCHAR(255) DEFAULT NULL, position VARCHAR(255) NOT NULL, phone VARCHAR(100) DEFAULT NULL, email VARCHAR(100) DEFAULT NULL, employee_id VARCHAR(20) NOT NULL, INDEX IDX_426EF39264D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff_department (staff_id INT NOT NULL, department_id INT NOT NULL, INDEX IDX_2B4FF15BD4D57CD (staff_id), INDEX IDX_2B4FF15BAE80F5DF (department_id), PRIMARY KEY(staff_id, department_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE department_department ADD CONSTRAINT FK_5F14ED664B908083 FOREIGN KEY (department_source) REFERENCES department (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE department_department ADD CONSTRAINT FK_5F14ED665275D00C FOREIGN KEY (department_target) REFERENCES department (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE staff ADD CONSTRAINT FK_426EF39264D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE staff_department ADD CONSTRAINT FK_2B4FF15BD4D57CD FOREIGN KEY (staff_id) REFERENCES staff (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE staff_department ADD CONSTRAINT FK_2B4FF15BAE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE department_department DROP FOREIGN KEY FK_5F14ED664B908083');
        $this->addSql('ALTER TABLE department_department DROP FOREIGN KEY FK_5F14ED665275D00C');
        $this->addSql('ALTER TABLE staff_department DROP FOREIGN KEY FK_2B4FF15BAE80F5DF');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18A64D218E');
        $this->addSql('ALTER TABLE staff DROP FOREIGN KEY FK_426EF39264D218E');
        $this->addSql('ALTER TABLE staff_department DROP FOREIGN KEY FK_2B4FF15BD4D57CD');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE department_department');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE staff');
        $this->addSql('DROP TABLE staff_department');
    }
}
