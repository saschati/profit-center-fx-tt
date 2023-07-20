<?php

declare(strict_types=1);

namespace App\Core\Validation;

use DomainException;
use Throwable;

class ValidateException extends DomainException implements ValidateExceptionInterface
{
    private array $errors;

    public function __construct(
        array $errors,
        string $message = 'Invalid validation.',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        $this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
