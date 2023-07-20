<?php

declare(strict_types=1);

namespace App\Domain\StockQuotes\Command;

use App\Core\Command\CommandInterface;
use App\Core\Validation\ValidateException;
use App\Domain\StockQuotes\DTO\Request\StockQuotesStatisticDto;
use App\Domain\StockQuotes\Entity\StockQuotesStatistic;
use App\Domain\StockQuotes\Repository\Interfaces\StockQuotesStatisticRepositoryInterface;
use DateTimeImmutable;
use Exception;

class SaveStatisticCommand implements CommandInterface
{
    public function __construct(
        private readonly string $uid,
        private readonly StockQuotesStatisticDto $dto,
        private readonly StockQuotesStatisticRepositoryInterface $repository
    ) {
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $errors = [];
        if ($this->dto->max < $this->dto->min) {
            $errors['max'] = '"max" не може бути меньше "min".';
        }

        if ($errors !== []) {
            throw new ValidateException($errors);
        }

        $entity = new StockQuotesStatistic();
        $entity
            ->setId($this->uid)
            ->setAverage($this->dto->average)
            ->setMax($this->dto->max)
            ->setMin($this->dto->min)
            ->setStandardDeviation($this->dto->standardDeviation)
            ->setMode($this->dto->mode)
            ->setSessionId($this->dto->sessionId)
            ->setStartDateAt(new DateTimeImmutable($this->dto->startDate))
            ->setEndDateAt(new DateTimeImmutable($this->dto->endDate))
            ->setCreatedAt(new DateTimeImmutable())
        ;

        $this->repository->persist($entity);
    }
}
