<?php

declare(strict_types=1);

namespace App\Core\Http\Message;

class RequestBug
{
    public function __construct(private array $bug)
    {
    }

    public function get(string $name): mixed
    {
        return $this->bug[$name] ?? null;
    }

    public function all(): array
    {
        return $this->bug;
    }

    public function has(string $name): bool
    {
        return \array_key_exists($name, $this->bug) === true;
    }
}
