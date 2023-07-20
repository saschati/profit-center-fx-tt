#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;

if (env('APP_DEBUG', false)) {
    \Symfony\Component\ErrorHandler\Debug::enable();
}

$application = new Application();

// ... register commands
// ...

$application->run();