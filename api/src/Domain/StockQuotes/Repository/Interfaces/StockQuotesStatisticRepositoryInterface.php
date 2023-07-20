<?php

declare(strict_types=1);

namespace App\Domain\StockQuotes\Repository\Interfaces;

use App\Core\DB\Repository\RepositoryInterface;
use App\Domain\StockQuotes\Entity\StockQuotesStatistic;

interface StockQuotesStatisticRepositoryInterface extends RepositoryInterface
{
    public function findOne(string $uid): ?StockQuotesStatistic;
}
