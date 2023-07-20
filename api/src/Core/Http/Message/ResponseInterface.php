<?php

declare(strict_types=1);

namespace App\Core\Http\Message;

interface ResponseInterface
{
    public function setStatusCode(int $statusCode): void;

    public function setContent(string $content): void;

    public function getContent(): string;

    public function getStatusCode(): int;

    public function sendContent(): void;

    public function setProtocolVersion(string $version): void;

    public function getProtocolVersion(string $version): string;

    public function send(): void;

    public function prepare(RequestInterface $request): void;
}
