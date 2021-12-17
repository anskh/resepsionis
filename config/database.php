<?php

declare(strict_types=1);

use PhpWeb\Config\Config;
use PhpWeb\Db\Database;

return [
    Config::ATTR_DB_DEFAULT_CONNECTION => 'mysql',
    Config::ATTR_DB_CONNECTION => [
        'mysql' => [
            Config::ATTR_DB_CONNECTION_DSN => Database::MYSQL . ':host=localhost;port=3306;dbname=resepsionis',
            Config::ATTR_DB_CONNECTION_USER => 'root',
            Config::ATTR_DB_CONNECTION_PASSWD => 'password',
            Config::ATTR_DB_CONNECTION_SCHEMA => '',
            Config::ATTR_DB_CONNECTION_TYPE => Database::MYSQL
        ],
        'sqlite' => [
            Config::ATTR_DB_CONNECTION_DSN => Database::SQLITE . ':' . ROOT . '/writeable/db/resepsionis.db',
            Config::ATTR_DB_CONNECTION_USER => '',
            Config::ATTR_DB_CONNECTION_PASSWD => '',
            Config::ATTR_DB_CONNECTION_SCHEMA => '',
            Config::ATTR_DB_CONNECTION_TYPE => Database::SQLITE
        ],
        'pgsql' => [
            Config::ATTR_DB_CONNECTION_DSN => Database::PGSQL . ':host=localhost;port=5432;dbname=resepsionis',
            Config::ATTR_DB_CONNECTION_USER => 'postgres',
            Config::ATTR_DB_CONNECTION_PASSWD => 'password',
            Config::ATTR_DB_CONNECTION_SCHEMA => 'public',
            Config::ATTR_DB_CONNECTION_TYPE => Database::PGSQL
        ]
    ],
    Config::ATTR_DB_PREFIX => 'tbl_',
    Config::ATTR_DB_MIGRATION => [
        Config::ATTR_DB_MIGRATION_PATH => ROOT . '/migration',
        Config::ATTR_DB_MIGRATION_ACTION => 'up'
    ]
];
