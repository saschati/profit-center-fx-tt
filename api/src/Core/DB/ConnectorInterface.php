<?php

declare(strict_types=1);

namespace App\Core\DB;

use PDO;

interface ConnectorInterface
{
    public function getPDO(): PDO;
}
