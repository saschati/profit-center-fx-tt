<?php

declare(strict_types=1);

namespace App\Http\Rest\Action;

use App\Core\Config\Config;
use App\Core\Http\Action\ActionInterface;
use App\Core\Http\Exception\MethodNotAllowedHttpException;
use App\Core\Http\Message\JsonResponse;
use App\Core\Http\Message\RequestInterface;
use App\Core\Http\Message\ResponseInterface;

final class HomeAction implements ActionInterface
{
    public function __construct(private readonly Config $config)
    {
    }

    public function __invoke(RequestInterface $request): ResponseInterface
    {
        if ($request->getMethod() !== 'GET') {
            throw new MethodNotAllowedHttpException();
        }

        return new JsonResponse([
            'name' => $this->config->getAppName(),
            'version' => $this->config->get('version'),
        ]);
    }
}
