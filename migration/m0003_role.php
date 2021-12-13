<?php

declare(strict_types=1);

use PhpWeb\Config\Config;
use PhpWeb\Db\Migration;

use function PhpWeb\app;

class m0003_role extends Migration
{
    protected string $table = Config::ACCESSCONTROL_ROLE;

    public function up(): bool
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . app()->db()->table($this->table) . '(
            id INT(11) NOT NULL AUTO_INCREMENT,' .
            Config::ACCESSCONTROL_ROLE_NAME . ' VARCHAR(255) NOT NULL UNIQUE,
            PRIMARY KEY (id)
        )ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;';

        try {
            app()->db()->connection()->exec($sql);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function seed(): bool
    {
        $data = [
            [
                Config::ACCESSCONTROL_ROLE_NAME => 'admin'
            ],
            [
                Config::ACCESSCONTROL_ROLE_NAME => 'user'
            ]
        ];

        try {
            app()->db()->insert($data, $this->table);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
