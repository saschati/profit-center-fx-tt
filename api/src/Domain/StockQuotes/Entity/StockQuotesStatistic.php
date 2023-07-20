<?php

declare(strict_types=1);

namespace App\Domain\StockQuotes\Entity;

use App\Core\Entity\Entity;
use DateTimeInterface;

class StockQuotesStatistic extends Entity
{
    private string $id;
    private float $average;
    private int $max;
    private int $min;
    private float $standardDeviation;
    private int $mode;
    private string $sessionId;
    private DateTimeInterface $startDateAt;
    private DateTimeInterface $endDateAt;
    private DateTimeInterface $createdAt;

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setAverage(float $average): static
    {
        $this->average = $average;

        return $this;
    }

    public function setMax(int $max): static
    {
        $this->max = $max;

        return $this;
    }

    public function setMin(int $min): static
    {
        $this->min = $min;

        return $this;
    }

    public function setStandardDeviation(float $standardDeviation): static
    {
        $this->standardDeviation = $standardDeviation;

        return $this;
    }

    public function setMode(int $mode): static
    {
        $this->mode = $mode;

        return $this;
    }

    public function setSessionId(string $sessionId): static
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function setStartDateAt(DateTimeInterface $startDateAt): static
    {
        $this->startDateAt = $startDateAt;

        return $this;
    }

    public function setEndDateAt(DateTimeInterface $endDateAt): static
    {
        $this->endDateAt = $endDateAt;

        return $this;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAverage(): float
    {
        return $this->average;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function getStandardDeviation(): float
    {
        return $this->standardDeviation;
    }

    public function getMode(): int
    {
        return $this->mode;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getStartDateAt(): DateTimeInterface
    {
        return $this->startDateAt;
    }

    public function getEndDateAt(): DateTimeInterface
    {
        return $this->endDateAt;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
