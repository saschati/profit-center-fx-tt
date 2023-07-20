<?php

declare(strict_types=1);

return [
    // Main
    'name' => env('APP_NAME'),
    'containers' => require __DIR__ . '/containers.php',

    // Pagination
    'pageSize' => 20,
];
