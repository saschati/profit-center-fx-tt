<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;

return [
    'version' => '1.0.0',
    'routes' => require __DIR__ . '/routes.php',
    'containers' => [
        'definitions' => [
            \App\Http\Rest\Action\HomeAction::class => static fn (ContainerInterface $container) => new App\Http\Rest\Action\HomeAction($container->get('config')),
            \App\Domain\StockQuotes\Http\Rest\Action\StockQuotes\CreateStatisticAction::class => static function (ContainerInterface $container) {
                return new \App\Domain\StockQuotes\Http\Rest\Action\StockQuotes\CreateStatisticAction(
                    $container->get(App\Domain\StockQuotes\Repository\Interfaces\StockQuotesStatisticRepositoryInterface::class)
                );
            },
            \App\Domain\StockQuotes\Http\Rest\Action\StockQuotes\ListStatisticAction::class => static function (ContainerInterface $container) {
                return new \App\Domain\StockQuotes\Http\Rest\Action\StockQuotes\ListStatisticAction(
                    $container->get(App\Domain\StockQuotes\Repository\Interfaces\StockQuotesStatisticRepositoryInterface::class),
                    $container->get('config')
                );
            },
        ],
        'singletons' => [
            \App\Core\Http\ErrorHandler\ErrorHandlerInterface::class => static fn () => new \App\Core\Http\ErrorHandler\RestErrorHandler(),
        ],
    ],
];
