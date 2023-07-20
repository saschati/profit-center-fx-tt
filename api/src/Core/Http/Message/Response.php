<?php

declare(strict_types=1);

namespace App\Core\Http\Message;

use InvalidArgumentException;

class Response implements ResponseInterface
{
    public static $statusTexts = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // RFC2518
        103 => 'Early Hints',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already Reported',      // RFC5842
        226 => 'IM Used',               // RFC3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',    // RFC7238
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Content Too Large',                                           // RFC-ietf-httpbis-semantics
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',                                               // RFC2324
        421 => 'Misdirected Request',                                         // RFC7540
        422 => 'Unprocessable Content',                                       // RFC-ietf-httpbis-semantics
        423 => 'Locked',                                                      // RFC4918
        424 => 'Failed Dependency',                                           // RFC4918
        425 => 'Too Early',                                                   // RFC-ietf-httpbis-replay-04
        426 => 'Upgrade Required',                                            // RFC2817
        428 => 'Precondition Required',                                       // RFC6585
        429 => 'Too Many Requests',                                           // RFC6585
        431 => 'Request Header Fields Too Large',                             // RFC6585
        451 => 'Unavailable For Legal Reasons',                               // RFC7725
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',                                     // RFC2295
        507 => 'Insufficient Storage',                                        // RFC4918
        508 => 'Loop Detected',                                               // RFC5842
        510 => 'Not Extended',                                                // RFC2774
        511 => 'Network Authentication Required',                             // RFC6585
    ];
    private int $statusCode;
    private string $statusText;
    private string $content;
    private string $version;
    private array $headers;

    public function __construct(?string $content = '', int $status = 200, array $headers = [])
    {
        $this->headers = $headers;
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->setProtocolVersion('1.0');
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
        if ($this->statusCode < 100 || $this->statusCode >= 600) {
            throw new InvalidArgumentException(sprintf('The HTTP status code "%s" is not valid.', $statusCode));
        }

        $this->statusText = self::$statusTexts[$this->statusCode] ?? 'unknown status';
    }

    public function setProtocolVersion(string $version): void
    {
        $this->version = $version;
    }

    public function getProtocolVersion(string $version): string
    {
        return $this->version;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content ?? '';
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function sendHeaders(): void
    {
        // headers have already been sent by the developer
        if (headers_sent()) {
            return;
        }

        foreach ($this->headers as $name => $value) {
            header(sprintf('%s:%s', $name, $value), false, $this->statusCode);
        }

        // status
        header(
            sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText),
            true,
            $this->statusCode
        );
    }

    public function sendContent(): void
    {
        echo $this->content;
    }

    public function prepare(RequestInterface $request): void
    {
        $this->headers['Content-Type'] ??= $request->getHeaders()->get('Content-Type');

        if ('HTTP/1.0' !== $request->getServer()->get('SERVER_PROTOCOL')) {
            $this->setProtocolVersion('1.1');
        }
    }

    public function send(): void
    {
        $this->sendHeaders();
        $this->sendContent();

        if (\function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } elseif (\function_exists('litespeed_finish_request')) {
            litespeed_finish_request();
        }
    }
}
