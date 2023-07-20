<?php

declare(strict_types=1);

return [
    'dbname' => env('DB_DATABASE'),
    'user' => env('DB_USER'),
    'password' => env('DB_PASSWORD'),
    'host' => env('DB_HOST'),
    'driver' => 'pdo_mysql',
];
