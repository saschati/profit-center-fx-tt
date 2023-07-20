<?php

declare(strict_types=1);

namespace App\Core\DependencyInjection;

use InvalidArgumentException;
use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
}
