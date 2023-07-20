<?php

declare(strict_types=1);

namespace App\Core\DependencyInjection;

class Container implements ContainerInterface
{
    private array $dependencies = [];

    public function get(string $id)
    {
        if ($this->has($id) === false) {
            throw new NotFoundException(sprintf('No entry with this id - "%s" was found', $id));
        }

        $dependency = $this->dependencies[$id];
        if ($dependency['isSingleton'] === true) {
            return $dependency['instance'] ??= $dependency['resolver']($this);
        }

        return $dependency['resolver']($this);
    }

    public function has(string $id): bool
    {
        return \array_key_exists($id, $this->dependencies) === true;
    }

    public function set(string $id, callable $resolver, bool $isSingleton = false): void
    {
        $this->dependencies[$id] = [
            'id' => $id,
            'resolver' => $resolver,
            'isSingleton' => $isSingleton,
        ];
    }
}
