<?php

declare(strict_types=1);

namespace App\Core\DependencyInjection;

use Psr\Container\ContainerInterface as PsrContainerInterface;

interface ContainerInterface extends PsrContainerInterface
{
    public function set(string $id, callable $resolver, bool $isSingleton): void;
}
