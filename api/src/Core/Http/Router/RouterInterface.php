<?php

declare(strict_types=1);

namespace App\Core\Http\Router;

use App\Core\Http\Action\ActionInterface;
use App\Core\Http\Exception\NotFoundHttpExceptionInterface;

interface RouterInterface
{
    /**
     * @throws NotFoundHttpExceptionInterface
     */
    public function getAction(string $route): ActionInterface;

    public function setRoutes(array $routes): void;
}
