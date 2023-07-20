<?php

declare(strict_types=1);

namespace App\Core\Http\Exception;

use DomainException;

class MethodNotAllowedHttpException extends DomainException implements MethodNotAllowedHttpExceptionInterface
{
    public function __construct(
        $message = 'Method Not Allowed.',
        $code = 0,
        $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
