<?php

declare(strict_types=1);

namespace App\Core\Entity;

use App\Core\Http\Exception\NotFoundHttpExceptionInterface;
use DomainException;

class EntityNotFoundException extends DomainException implements NotFoundHttpExceptionInterface
{
    public function __construct(
        $message = 'Entity no found.',
        $code = 0,
        $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
