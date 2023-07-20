<?php

require __DIR__ . '/../../vendor/autoload.php';

if (env('APP_DEBUG', false)) {
    \Symfony\Component\ErrorHandler\Debug::enable();
}

$config = App\Core\Config\Config::marge(
    require __DIR__ . '/../../src/Config/common.php',
    require __DIR__ . '/../../src/Config/Rest/index.php',
);

$request = \App\Core\Http\Message\Request::createFromGlobals();
$kernel = new \App\Core\Http\Kernel\Kernel($config);
$response = $kernel->handle($request);
$response->send();