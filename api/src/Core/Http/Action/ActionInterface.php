<?php

declare(strict_types=1);

namespace App\Core\Http\Action;

use App\Core\Http\Message\RequestInterface;
use App\Core\Http\Message\ResponseInterface;

interface ActionInterface
{
    public function __invoke(RequestInterface $request): ResponseInterface;
}
