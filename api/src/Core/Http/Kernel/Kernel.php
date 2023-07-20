<?php

declare(strict_types=1);

namespace App\Core\Http\Kernel;

use App\Core\Config\Config;
use App\Core\DependencyInjection\Container;
use App\Core\DependencyInjection\ContainerInterface;
use App\Core\Http\ErrorHandler\ErrorHandlerInterface;
use App\Core\Http\Message\RequestInterface;
use App\Core\Http\Message\ResponseInterface;
use App\Core\Http\Router\Router;
use App\Core\Http\Router\RouterInterface;
use Throwable;

class Kernel implements KernelInterface
{
    private ContainerInterface $container;
    private RouterInterface $router;

    public function __construct(
        private array $config,
    ) {
        $this->container = new Container();
        $this->router = new Router($this->container);
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        $this->setUpConfig();

        try {
            $path = $request->getPath();
            $action = $this->router->getAction($path);

            $response = $action($request);
        } catch (Throwable $e) {
            /** @var ErrorHandlerInterface $handler */
            $handler = $this->container->get(ErrorHandlerInterface::class);

            $response = $handler->handler($e);
        }

        $response->prepare($request);

        return $response;
    }

    private function setUpConfig(): void
    {
        $this->setUpContainer($this->config['containers'] ?? []);
        $this->setUpRoutes($this->config['routes'] ?? []);

        unset(
            $this->config['containers'],
            $this->config['routes'],
        );

        $this->container->set('config', fn () => new Config($this->config), true);
    }

    private function setUpContainer(array $container): void
    {
        foreach ($container['singletons'] ?? [] as $id => $resolver) {
            $this->container->set($id, $resolver, true);
        }

        foreach ($container['definitions'] ?? [] as $id => $resolver) {
            $this->container->set($id, $resolver);
        }
    }

    private function setUpRoutes(array $routes): void
    {
        $this->router->setRoutes($routes);
    }
}
