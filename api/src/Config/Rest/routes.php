<?php

declare(strict_types=1);

return [
    '/' => \App\Http\Rest\Action\HomeAction::class,
    '/stock-quotes/statistics/save' => \App\Domain\StockQuotes\Http\Rest\Action\StockQuotes\CreateStatisticAction::class,
    '/stock-quotes/statistics' => \App\Domain\StockQuotes\Http\Rest\Action\StockQuotes\ListStatisticAction::class,
];
