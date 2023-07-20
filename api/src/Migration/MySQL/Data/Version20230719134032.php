<?php

declare(strict_types=1);

namespace App\Migration\MySQL\Data;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230719134032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table "stock_quotes_statistics"';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE stock_quotes_statistics (
              id VARCHAR(36) PRIMARY KEY,
              average DECIMAL(10, 2) NOT NULL,
              max INT(4) NOT NULL,
              min INT(4) NOT NULL,
              standard_deviation DECIMAL(10, 2) NOT NULL,
              mode INT(4) NOT NULL,
              session_id VARCHAR(36) NOT NULL,
              start_date_at TIMESTAMP NOT NULL,
              end_date_at TIMESTAMP NOT NULL,
              created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              INDEX idx_session_id (session_id)
            );
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE stock_quotes_statistics');
    }
}
