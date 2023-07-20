<?php

declare(strict_types=1);

use App\Core\DependencyInjection\Container;

return [
    'definitions' => [
    ],
    'singletons' => [
        \App\Core\DB\ConnectorInterface::class => static function () {
            return new \App\Core\DB\MySQL\Connector(
                env('DB_DATABASE'),
                env('DB_USER'),
                env('DB_PASSWORD'),
                env('DB_HOST')
            );
        },
        \App\Core\Http\ErrorHandler\ErrorHandlerInterface::class => static fn () => new \App\Core\Http\ErrorHandler\WebErrorHandler(),
        \App\Domain\StockQuotes\Repository\Interfaces\StockQuotesStatisticRepositoryInterface::class => static function (Container $container) {
            return new App\Domain\StockQuotes\Repository\MySQL\StockQuotesStatisticRepository(
                $container->get(\App\Core\DB\ConnectorInterface::class),
            );
        },
    ],
];
