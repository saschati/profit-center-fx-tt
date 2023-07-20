<?php

declare(strict_types=1);

namespace App\Domain\StockQuotes\Http\Rest\Action\StockQuotes;

use App\Core\Config\Config;
use App\Core\Http\Action\ActionInterface;
use App\Core\Http\Exception\MethodNotAllowedHttpException;
use App\Core\Http\Message\JsonResponse;
use App\Core\Http\Message\RequestInterface;
use App\Core\Http\Message\ResponseInterface;
use App\Domain\StockQuotes\DTO\Filter\StockQuotesStatisticFilter;
use App\Domain\StockQuotes\Entity\StockQuotesStatistic;
use App\Domain\StockQuotes\Repository\Interfaces\StockQuotesStatisticRepositoryInterface;

final class ListStatisticAction implements ActionInterface
{
    public function __construct(
        private readonly StockQuotesStatisticRepositoryInterface $repository,
        private readonly Config $config
    ) {
    }

    public function __invoke(RequestInterface $request): ResponseInterface
    {
        if ($request->getMethod() !== 'GET') {
            throw new MethodNotAllowedHttpException();
        }

        $filter = StockQuotesStatisticFilter::createFromArray($request->getQuery()->all());

        $pagination = $this->repository->findAll(
            $filter,
            (int)$request->get('page', 1),
            $this->config->get('pageSize', 20)
        );

        return new JsonResponse([
            'data' => array_map(static function (StockQuotesStatistic $entity) {
                return [
                    'id' => $entity->getId(),
                    'average' => $entity->getAverage(),
                    'max' => $entity->getMax(),
                    'min' => $entity->getMin(),
                    'standardDeviation' => $entity->getStandardDeviation(),
                    'mode' => $entity->getMode(),
                    'sessionId' => $entity->getSessionId(),
                    'startDate' => $entity->getStartDateAt()->format('Y-m-d\TH:i:s.v'),
                    'endDate' => $entity->getEndDateAt()->format('Y-m-d\TH:i:s.v'),
                    'createdAt' => $entity->getCreatedAt()->format('Y-m-d\TH:i:s.v'),
                ];
            }, $pagination->items()),
            'meta' => [
                'currentPage' => $pagination->page(),
                'totalPages' => $pagination->totalPage(),
                'totalItems' => $pagination->total(),
                'perPage' => $pagination->perPage(),
            ],
        ]);
    }
}
