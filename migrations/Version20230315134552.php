<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315134552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ability (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ability_pokemon (ability_id INT NOT NULL, pokemon_id INT NOT NULL, INDEX IDX_1E1671618016D8B2 (ability_id), INDEX IDX_1E1671612FE71C3E (pokemon_id), PRIMARY KEY(ability_id, pokemon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ability_pokemon ADD CONSTRAINT FK_1E1671618016D8B2 FOREIGN KEY (ability_id) REFERENCES ability (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ability_pokemon ADD CONSTRAINT FK_1E1671612FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE type ADD name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ability_pokemon DROP FOREIGN KEY FK_1E1671618016D8B2');
        $this->addSql('ALTER TABLE ability_pokemon DROP FOREIGN KEY FK_1E1671612FE71C3E');
        $this->addSql('DROP TABLE ability');
        $this->addSql('DROP TABLE ability_pokemon');
        $this->addSql('ALTER TABLE pokemon DROP description');
        $this->addSql('ALTER TABLE type DROP name');
    }
}
