<?php

declare(strict_types=1);

namespace App\Domain\StockQuotes\Repository\MySQL;

use App\Core\DB\ConnectorInterface;
use App\Core\DB\MySQL\DataColumn;
use App\Core\DB\Repository\FilterRequest;
use App\Core\DB\Repository\RecordPagination;
use App\Core\Entity\EntityInterface;
use App\Core\Helper\ArrayHelper;
use App\Domain\StockQuotes\DTO\Filter\StockQuotesStatisticFilter;
use App\Domain\StockQuotes\Entity\StockQuotesStatistic;
use App\Domain\StockQuotes\Repository\Interfaces\StockQuotesStatisticRepositoryInterface;
use DateTimeImmutable;
use Exception;
use PDO;

class StockQuotesStatisticRepository implements StockQuotesStatisticRepositoryInterface
{
    public function __construct(private ConnectorInterface $connector)
    {
    }

    /**
     * @param StockQuotesStatistic $entity
     */
    public function persist(EntityInterface $entity): void
    {
        $pdo = $this->connector->getPDO();

        $query = 'INSERT INTO stock_quotes_statistics (
                    standard_deviation,
                    average,
                    max,
                    min,
                    id,
                    session_id,
                    mode,
                    end_date_at,
                    start_date_at,
                    created_at
                  ) VALUES (
                    :standard_deviation,
                    :average,
                    :max,
                    :min,
                    :id,
                    :session_id,
                    :mode,
                    :end_date_at,
                    :start_date_at,
                    :created_at
                  )';
        $stmt = $pdo->prepare($query);

        $stmt->bindValue(':standard_deviation', $entity->getStandardDeviation());
        $stmt->bindValue(':average', $entity->getAverage());
        $stmt->bindValue(':max', $entity->getMax(), PDO::PARAM_INT);
        $stmt->bindValue(':min', $entity->getMin(), PDO::PARAM_INT);
        $stmt->bindValue(':id', $entity->getId());
        $stmt->bindValue(':session_id', $entity->getSessionId());
        $stmt->bindValue(':mode', $entity->getMode(), PDO::PARAM_INT);
        $stmt->bindValue(':end_date_at', $entity->getEndDateAt()->format(DataColumn::DATETIME_FORMAT));
        $stmt->bindValue(':start_date_at', $entity->getStartDateAt()->format(DataColumn::DATETIME_FORMAT));
        $stmt->bindValue(':created_at', $entity->getCreatedAt()->format(DataColumn::DATETIME_FORMAT));

        $stmt->execute();
    }

    public function findOne(string $uid): ?StockQuotesStatistic
    {
        $pdo = $this->connector->getPDO();

        $query = 'SELECT * FROM stock_quotes_statistics WHERE id=:uid';
        $stmt = $pdo->prepare($query);

        $stmt->bindValue(':uid', $uid);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data === false) {
            return null;
        }

        return $this->mapDataToEntity($data);
    }

    /**
     * @param StockQuotesStatisticFilter $filter
     *
     * @throws Exception
     */
    public function findAll(FilterRequest $filter, int $page, int $perPage = 20): RecordPagination
    {
        $pdo = $this->connector->getPDO();

        $queryTemplate = 'SELECT %s FROM stock_quotes_statistics';

        $condition = [];
        $bindValues = [];

        if (ArrayHelper::isEmpty($filter->lessCreateAt) === false) {
            $datetime = new DateTimeImmutable($filter->lessCreateAt);

            $bindValues[':created_at'] = $datetime->format(DataColumn::DATETIME_FORMAT);
            $condition[] = 'created_at <= :created_at';
        }

        if ($condition !== []) {
            $queryTemplate = sprintf('%s WHERE %s', $queryTemplate, implode(' AND ', $condition));
        }

        $countQuery = sprintf($queryTemplate, 'COUNT(*) as total');
        $query = sprintf(
            '%s  ORDER BY created_at DESC LIMIT %s OFFSET %s',
            sprintf($queryTemplate, '*'),
            $perPage,
            ($page - 1) * $perPage
        );

        $stmtCount = $pdo->prepare($countQuery);
        $stmt = $pdo->prepare($query);

        foreach ($bindValues as $bind => $value) {
            $stmt->bindValue($bind, $value);
            $stmtCount->bindValue($bind, $value);
        }

        $stmtCount->execute();
        $stmt->execute();

        $total = $stmtCount->fetchColumn();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($data === false) {
            return new RecordPagination([], $total, $page, $perPage);
        }

        $map = [];
        foreach ($data as $item) {
            $map[] = $this->mapDataToEntity($item);
        }

        return new RecordPagination($map, $total, $page, $perPage);
    }

    private function mapDataToEntity(array $data): StockQuotesStatistic
    {
        $entity = new StockQuotesStatistic();
        $entity
            ->setId($data['id'])
            ->setAverage((float)$data['average'])
            ->setMax($data['max'])
            ->setMin($data['min'])
            ->setStandardDeviation((float)$data['standard_deviation'])
            ->setMode($data['mode'])
            ->setSessionId($data['session_id'])
            ->setStartDateAt(DateTimeImmutable::createFromFormat(DataColumn::DATETIME_FORMAT, $data['start_date_at']))
            ->setEndDateAt(DateTimeImmutable::createFromFormat(DataColumn::DATETIME_FORMAT, $data['end_date_at']))
            ->setCreatedAt(DateTimeImmutable::createFromFormat(DataColumn::DATETIME_FORMAT, $data['created_at']))
        ;

        return $entity;
    }
}
