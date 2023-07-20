<?php

declare(strict_types=1);

namespace App\Core\DB\Repository;

class RecordPagination
{
    private int $total;
    private int $page;
    private int $perPage;
    private array $items;

    public function __construct(array $items, int $total, int $page, int $perPage)
    {
        $this->items = $items;
        $this->total = $total;
        $this->page = $page;
        $this->perPage = $perPage;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function totalPage(): int
    {
        return (int)ceil($this->total / $this->perPage);
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function items(): array
    {
        return $this->items;
    }

    public function nextPage(): int
    {
        return $this->page + 1;
    }
}
