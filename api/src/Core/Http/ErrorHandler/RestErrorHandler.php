<?php

declare(strict_types=1);

namespace App\Core\Http\ErrorHandler;

use App\Core\Http\Exception\MethodNotAllowedHttpExceptionInterface;
use App\Core\Http\Exception\NotFoundHttpExceptionInterface;
use App\Core\Http\Message\JsonResponse;
use App\Core\Http\Message\ResponseInterface;
use App\Core\Validation\ValidateExceptionInterface;
use Throwable;

class RestErrorHandler implements ErrorHandlerInterface
{
    public function handler(Throwable $throwable): ResponseInterface
    {
        if ($throwable instanceof NotFoundHttpExceptionInterface) {
            return new JsonResponse(['message' => $throwable->getMessage(), 'code' => 404], 404);
        }

        if ($throwable instanceof MethodNotAllowedHttpExceptionInterface) {
            return new JsonResponse(['message' => $throwable->getMessage(), 'code' => 405], 405);
        }

        if ($throwable instanceof ValidateExceptionInterface) {
            return new JsonResponse([
                'message' => $throwable->getMessage(),
                'code' => 422,
                'errors' => $throwable->getErrors(),
            ], 422);
        }

        throw $throwable;
    }
}
