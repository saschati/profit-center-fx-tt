<?php

declare(strict_types=1);

namespace App\Domain\StockQuotes\DTO\Request;

use App\Core\DTO\ArrayToObject;

class StockQuotesStatisticDto
{
    use ArrayToObject;

    public float $average = 0;
    public int $max = 0;
    public int $min = 0;
    public float $standardDeviation = 0;
    public int $mode = 0;
    public string $sessionId = '';
    public string $startDate = '';
    public string $endDate = '';
}
