<?php

declare(strict_types=1);

namespace App\Core\Http\Router;

use App\Core\Http\Exception\NotFoundHttpExceptionInterface;
use InvalidArgumentException;

class RouteNotFoundException extends InvalidArgumentException implements NotFoundHttpExceptionInterface
{
    public function __construct(
        $message = 'Route no found.',
        $code = 0,
        $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
