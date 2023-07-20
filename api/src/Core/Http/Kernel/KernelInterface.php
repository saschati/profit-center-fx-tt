<?php

declare(strict_types=1);

namespace App\Core\Http\Kernel;

use App\Core\Http\Message\RequestInterface;
use App\Core\Http\Message\ResponseInterface;

interface KernelInterface
{
    public function handle(RequestInterface $request): ResponseInterface;
}
