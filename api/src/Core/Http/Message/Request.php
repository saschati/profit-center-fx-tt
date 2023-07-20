<?php

declare(strict_types=1);

namespace App\Core\Http\Message;

use JsonException;

class Request implements RequestInterface
{
    private RequestBug $query;
    private RequestBug $request;
    private RequestBug $post;
    private RequestBug $cookies;
    private RequestBug $files;
    private RequestBug $server;
    private RequestBug $headers;

    public function __construct(
        array $query = [],
        array $request = [],
        array $post = [],
        array $cookies = [],
        array $files = [],
        array $server = []
    ) {
        $this->query = new RequestBug($query);
        $this->request = new RequestBug($request);
        $this->post = new RequestBug($post);
        $this->cookies = new RequestBug($cookies);
        $this->files = new RequestBug($files);
        $this->server = new RequestBug($server);
        $this->headers = new RequestBug(getallheaders());

        if (\in_array(mb_strtoupper($this->getMethod()), ['PUT', 'POST', 'PATCH'], true) === true) {
            $content = file_get_contents('php://input');
            if (empty($content) === false) {
                $post = json_decode($content, true, 512, JSON_BIGINT_AS_STRING | JSON_THROW_ON_ERROR);

                $this->post = new RequestBug($post);
            }
        }
    }

    public function get(string $name, mixed $default = null): mixed
    {
        if ($this->query->has($name)) {
            return $this->query->get($name);
        }

        if ($this->post->has($name)) {
            return $this->post->get($name);
        }

        return $default;
    }

    public function getMethod(): string
    {
        /** @var string $method */
        $method = $this->server->get('REQUEST_METHOD');

        return mb_strtoupper($method);
    }

    public function getPath(): string
    {
        /** @var string $path */
        return parse_url($this->server->get('REQUEST_URI'), PHP_URL_PATH);
    }

    /**
     * @throws JsonException
     */
    public static function createFromGlobals(): static
    {
        return new static($_GET, $_REQUEST, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getQuery(): RequestBug
    {
        return $this->query;
    }

    public function getRequest(): RequestBug
    {
        return $this->request;
    }

    public function getPost(): RequestBug
    {
        return $this->post;
    }

    public function getCookies(): RequestBug
    {
        return $this->cookies;
    }

    public function getFiles(): RequestBug
    {
        return $this->files;
    }

    public function getServer(): RequestBug
    {
        return $this->server;
    }

    public function getHeaders(): RequestBug
    {
        return $this->headers;
    }
}
