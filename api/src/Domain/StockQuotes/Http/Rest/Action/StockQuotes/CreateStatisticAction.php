<?php

declare(strict_types=1);

namespace App\Domain\StockQuotes\Http\Rest\Action\StockQuotes;

use App\Core\Entity\EntityNotFoundException;
use App\Core\Http\Action\ActionInterface;
use App\Core\Http\Exception\MethodNotAllowedHttpException;
use App\Core\Http\Message\JsonResponse;
use App\Core\Http\Message\RequestInterface;
use App\Core\Http\Message\ResponseInterface;
use App\Domain\StockQuotes\Command\SaveStatisticCommand;
use App\Domain\StockQuotes\DTO\Request\StockQuotesStatisticDto;
use App\Domain\StockQuotes\Repository\Interfaces\StockQuotesStatisticRepositoryInterface;
use Ramsey\Uuid\Uuid;

final class CreateStatisticAction implements ActionInterface
{
    public function __construct(private readonly StockQuotesStatisticRepositoryInterface $repository)
    {
    }

    public function __invoke(RequestInterface $request): ResponseInterface
    {
        if ($request->getMethod() !== 'POST') {
            throw new MethodNotAllowedHttpException();
        }

        $dto = StockQuotesStatisticDto::createFromArray($request->getPost()->all());

        $command = new SaveStatisticCommand($id = Uuid::uuid4()->toString(), $dto, $this->repository);
        $command->execute();

        $entity = $this->repository->findOne($id);
        if ($entity === null) {
            throw new EntityNotFoundException();
        }

        return new JsonResponse([
            'data' => [
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
            ],
        ]);
    }
}
