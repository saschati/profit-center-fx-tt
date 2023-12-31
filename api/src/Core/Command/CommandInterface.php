<?php

declare(strict_types=1);

namespace App\Core\Command;

interface CommandInterface
{
    public function execute(): void;
}
