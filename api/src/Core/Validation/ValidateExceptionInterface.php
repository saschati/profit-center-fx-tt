<?php

declare(strict_types=1);

namespace App\Core\Validation;

interface ValidateExceptionInterface
{
    public function getErrors(): array;
}
