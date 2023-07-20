<?php

declare(strict_types=1);

namespace App\Core\Entity;

interface EntityInterface
{
    public function isNewRecord(): bool;

    public function setIsNewRecord(bool $isNew): static;
}
