<?php

declare(strict_types=1);

namespace App\Core\Http\Message;

interface RequestInterface
{
    public function getQuery(): RequestBug;

    public function getRequest(): RequestBug;

    public function getPost(): RequestBug;

    public function getCookies(): RequestBug;

    public function getFiles(): RequestBug;

    public function getServer(): RequestBug;

    public function getHeaders(): RequestBug;

    public function get(string $name, mixed $default): mixed;

    public function getMethod(): string;

    public function getPath(): string;
}
