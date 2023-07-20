<?php

declare(strict_types=1);

namespace App\Core\Http\Message;

use JsonException;

class JsonResponse extends Response
{
    /**
     * @throws JsonException
     */
    public function __construct(?array $content = [], int $status = 200, array $headers = [])
    {
        $headers = array_merge($headers, ['Content-Type' => 'application/json']);
        $content = json_encode($content, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

        parent::__construct($content, $status, $headers);
    }
}
