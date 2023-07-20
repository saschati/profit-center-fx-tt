<?php

declare(strict_types=1);

namespace App\Core\DB\MySQL;

use App\Core\DB\ConnectorInterface;
use PDO;

class Connector implements ConnectorInterface
{
    private PDO|null $pdo;

    public function __construct(
        string $db,
        string $user,
        string $pass,
        string $host,
    ) {
        $this->pdo = new PDO(sprintf('mysql:host=%s;dbname=%s', $host, $db), $user, $pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
}
