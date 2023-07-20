<?php

declare(strict_types=1);

namespace App\Core\DB\Repository;

use App\Core\Entity\EntityInterface;

interface RepositoryInterface
{
    public function persist(EntityInterface $entity): void;

    public function findOne(string $uid): ?EntityInterface;

    public function findAll(FilterRequest $filter, int $page, int $perPage): RecordPagination;
}
