<?php

declare(strict_types=1);

namespace App\Domain\StockQuotes\DTO\Filter;

use App\Core\DB\Repository\FilterRequest;
use App\Core\DTO\ArrayToObject;

class StockQuotesStatisticFilter implements FilterRequest
{
    use ArrayToObject;

    public string $lessCreateAt = '';
}
