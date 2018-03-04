<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20180304085803 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lshop_activations (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, code VARCHAR(64) NOT NULL, completed_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C4AD3053A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_categories (id INT AUTO_INCREMENT NOT NULL, server_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E58BBDB31844E6B7 (server_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_items (id INT AUTO_INCREMENT NOT NULL, `name` VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(32) NOT NULL, image VARCHAR(255) DEFAULT NULL, game_id VARCHAR(255) NOT NULL, extra LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_news (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1279E70DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_pages (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, url VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_35A16242F47645AE (url), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_permissions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, UNIQUE INDEX UNIQ_3C33BFC85E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_permission_user (permission_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_2F5D723FFED90CCA (permission_id), INDEX IDX_2F5D723FA76ED395 (user_id), PRIMARY KEY(permission_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_permission_role (permission_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_F5A72E1CFED90CCA (permission_id), INDEX IDX_F5A72E1CD60322AC (role_id), PRIMARY KEY(permission_id, role_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_persistences (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, code VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_9E86B38D77153098 (code), INDEX IDX_9E86B38DA76ED395 (user_id), INDEX search_idx (code, user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_products (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, category_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, stack INT NOT NULL, sort_priority DOUBLE PRECISION NOT NULL, hidden TINYINT(1) NOT NULL, INDEX IDX_10E5818D126F525E (item_id), INDEX IDX_10E5818D12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_reminders (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, code VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7586A178A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(32) NOT NULL, UNIQUE INDEX UNIQ_A3EBA9F05E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_role_user (role_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_2B38BC71D60322AC (role_id), INDEX IDX_2B38BC71A76ED395 (user_id), PRIMARY KEY(role_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_servers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, ip VARCHAR(45) DEFAULT NULL, port INT DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, enabled TINYINT(1) NOT NULL, monitoring_enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(32) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(60) NOT NULL, balance DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_15622DEF85E0677 (username), UNIQUE INDEX UNIQ_15622DEE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lshop_settings (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) NOT NULL, value LONGTEXT DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_461A7B124E645A7E (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lshop_activations ADD CONSTRAINT FK_C4AD3053A76ED395 FOREIGN KEY (user_id) REFERENCES lshop_users (id)');
        $this->addSql('ALTER TABLE lshop_categories ADD CONSTRAINT FK_E58BBDB31844E6B7 FOREIGN KEY (server_id) REFERENCES lshop_servers (id)');
        $this->addSql('ALTER TABLE lshop_news ADD CONSTRAINT FK_1279E70DA76ED395 FOREIGN KEY (user_id) REFERENCES lshop_users (id)');
        $this->addSql('ALTER TABLE lshop_permission_user ADD CONSTRAINT FK_2F5D723FFED90CCA FOREIGN KEY (permission_id) REFERENCES lshop_permissions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lshop_permission_user ADD CONSTRAINT FK_2F5D723FA76ED395 FOREIGN KEY (user_id) REFERENCES lshop_users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lshop_permission_role ADD CONSTRAINT FK_F5A72E1CFED90CCA FOREIGN KEY (permission_id) REFERENCES lshop_permissions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lshop_permission_role ADD CONSTRAINT FK_F5A72E1CD60322AC FOREIGN KEY (role_id) REFERENCES lshop_roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lshop_persistences ADD CONSTRAINT FK_9E86B38DA76ED395 FOREIGN KEY (user_id) REFERENCES lshop_users (id)');
        $this->addSql('ALTER TABLE lshop_products ADD CONSTRAINT FK_10E5818D126F525E FOREIGN KEY (item_id) REFERENCES lshop_items (id)');
        $this->addSql('ALTER TABLE lshop_products ADD CONSTRAINT FK_10E5818D12469DE2 FOREIGN KEY (category_id) REFERENCES lshop_categories (id)');
        $this->addSql('ALTER TABLE lshop_reminders ADD CONSTRAINT FK_7586A178A76ED395 FOREIGN KEY (user_id) REFERENCES lshop_users (id)');
        $this->addSql('ALTER TABLE lshop_role_user ADD CONSTRAINT FK_2B38BC71D60322AC FOREIGN KEY (role_id) REFERENCES lshop_roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lshop_role_user ADD CONSTRAINT FK_2B38BC71A76ED395 FOREIGN KEY (user_id) REFERENCES lshop_users (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lshop_products DROP FOREIGN KEY FK_10E5818D12469DE2');
        $this->addSql('ALTER TABLE lshop_products DROP FOREIGN KEY FK_10E5818D126F525E');
        $this->addSql('ALTER TABLE lshop_permission_user DROP FOREIGN KEY FK_2F5D723FFED90CCA');
        $this->addSql('ALTER TABLE lshop_permission_role DROP FOREIGN KEY FK_F5A72E1CFED90CCA');
        $this->addSql('ALTER TABLE lshop_permission_role DROP FOREIGN KEY FK_F5A72E1CD60322AC');
        $this->addSql('ALTER TABLE lshop_role_user DROP FOREIGN KEY FK_2B38BC71D60322AC');
        $this->addSql('ALTER TABLE lshop_categories DROP FOREIGN KEY FK_E58BBDB31844E6B7');
        $this->addSql('ALTER TABLE lshop_activations DROP FOREIGN KEY FK_C4AD3053A76ED395');
        $this->addSql('ALTER TABLE lshop_news DROP FOREIGN KEY FK_1279E70DA76ED395');
        $this->addSql('ALTER TABLE lshop_permission_user DROP FOREIGN KEY FK_2F5D723FA76ED395');
        $this->addSql('ALTER TABLE lshop_persistences DROP FOREIGN KEY FK_9E86B38DA76ED395');
        $this->addSql('ALTER TABLE lshop_reminders DROP FOREIGN KEY FK_7586A178A76ED395');
        $this->addSql('ALTER TABLE lshop_role_user DROP FOREIGN KEY FK_2B38BC71A76ED395');
        $this->addSql('DROP TABLE lshop_activations');
        $this->addSql('DROP TABLE lshop_categories');
        $this->addSql('DROP TABLE lshop_items');
        $this->addSql('DROP TABLE lshop_news');
        $this->addSql('DROP TABLE lshop_pages');
        $this->addSql('DROP TABLE lshop_permissions');
        $this->addSql('DROP TABLE lshop_permission_user');
        $this->addSql('DROP TABLE lshop_permission_role');
        $this->addSql('DROP TABLE lshop_persistences');
        $this->addSql('DROP TABLE lshop_products');
        $this->addSql('DROP TABLE lshop_reminders');
        $this->addSql('DROP TABLE lshop_roles');
        $this->addSql('DROP TABLE lshop_role_user');
        $this->addSql('DROP TABLE lshop_servers');
        $this->addSql('DROP TABLE lshop_users');
        $this->addSql('DROP TABLE lshop_settings');
    }
}
