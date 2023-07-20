<?php

declare(strict_types=1);

namespace App\Core\Http\ErrorHandler;

use App\Core\Http\Message\ResponseInterface;
use Throwable;

interface ErrorHandlerInterface
{
    public function handler(Throwable $throwable): ResponseInterface;
}
