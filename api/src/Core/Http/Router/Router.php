<?php

declare(strict_types=1);

namespace App\Core\Http\Router;

use App\Core\DependencyInjection\ContainerInterface;
use App\Core\Http\Action\ActionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Router implements RouterInterface
{
    private array $routes = [];

    public function __construct(private ContainerInterface $container)
    {
    }

    /**
     * @throws NotFoundExceptionInterface
     */
    public function getAction(string $route): ActionInterface
    {
        if (\array_key_exists($route, $this->routes) === false) {
            throw new RouteNotFoundException();
        }

        $id = $this->routes[$route];
        if ($this->container->has($id) === true) {
            /** @var ActionInterface $action */
            return $this->container->get($this->routes[$route]);
        }

        /** @var ActionInterface $action */
        return new $id();
    }

    public function setRoutes(array $routes): void
    {
        $this->routes = $routes;
    }
}
