<?php

declare(strict_types=1);

use Anskh\PhpWeb\Db\Database;

return [
    'mysql' => [
        Database::ATTR_DSN => Database::MYSQL . ':host=localhost;port=3306;dbname=resepsionis',
        Database::ATTR_USER => 'root',
        Database::ATTR_PASS => 'password',
        Database::ATTR_SCHEMA => '',
        Database::ATTR_PREFIX => 'tbl_'
    ],
    'sqlite' => [
        Database::ATTR_DSN => Database::SQLITE . ':' . ROOT . '/writeable/db/resepsionis.db',
        Database::ATTR_USER => '',
        Database::ATTR_PASS => '',
        Database::ATTR_SCHEMA => '',
        Database::ATTR_PREFIX => ''
    ],
    'pgsql' => [
        Database::ATTR_DSN => Database::PGSQL . ':host=localhost;port=5432;dbname=resepsionis',
        Database::ATTR_USER => 'postgres',
        Database::ATTR_PASS => 'password',
        Database::ATTR_SCHEMA => 'public',
        Database::ATTR_PREFIX => 'tbl_'
    ],
    'sqlsrv' => [
        Database::ATTR_DSN => Database::SQLSRV . ':Server=.\\sqlexpress;Database=resepsionis',
        Database::ATTR_USER => 'sa',
        Database::ATTR_PASS => 'password',
        Database::ATTR_SCHEMA => 'dbo',
        Database::ATTR_PREFIX => 'tbl_'
    ]
];
