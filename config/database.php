<?php

declare(strict_types=1);

return [
    'default_connection' => 'mysql',
    'connections' => [
        'mysql' => [
            'dsn' => 'mysql:host=localhost;port=3306;dbname=resepsionis',
            'user' => 'root',
            'password' => 'password'
        ],
        'sqlite' => [
            'dsn' => 'sqlite:' . ROOT . '/writeable/db/resepsionis.db'
        ],
        'pgsql' => [
            'dsn' => 'pgsql:host=localhost;port=5432;dbname=resepsionis',
            'user' => 'postgres',
            'password' => 'password'
        ]
    ],
    'prefix' => 'tbl_',
    'migration' => [
        'path' => ROOT . '/migration',
        'action' => 'up'
    ]
];
