<?php
declare(strict_types=1);

const DB_PATH = __DIR__ . '/../../database/database.db';

return [
    'sqlite' => [
        'driver' => 'pdo_sqlite',
        'path' => DB_PATH, 
    ],
];