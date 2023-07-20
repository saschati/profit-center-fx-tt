<?php

declare(strict_types=1);

namespace App\Core\Entity;

abstract class Entity implements EntityInterface
{
    private bool $isNewRecord = true;

    final public function isNewRecord(): bool
    {
        return $this->isNewRecord === true;
    }

    final public function setIsNewRecord(bool $isNew): static
    {
        $this->isNewRecord = $isNew;

        return $this;
    }
}
