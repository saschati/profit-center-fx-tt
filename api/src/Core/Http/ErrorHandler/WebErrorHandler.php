<?php

declare(strict_types=1);

namespace App\Core\Http\ErrorHandler;

use App\Core\Http\Exception\NotFoundHttpExceptionInterface;
use App\Core\Http\Message\Response;
use App\Core\Http\Message\ResponseInterface;
use Throwable;

class WebErrorHandler implements ErrorHandlerInterface
{
    public function handler(Throwable $throwable): ResponseInterface
    {
        if ($throwable instanceof NotFoundHttpExceptionInterface) {
            return new Response('Http no found!');
        }

        throw $throwable;
    }
}
