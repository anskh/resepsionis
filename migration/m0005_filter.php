<?php

declare(strict_types=1);

use PhpWeb\Config\Config;
use PhpWeb\Db\Migration;

use function PhpWeb\app;

class m0005_filter extends Migration
{
    protected string $table = Config::ACCESSCONTROL_FILTER;

    public function up(): bool
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . app()->db()->table($this->table) . '(
            id INT(11) NOT NULL AUTO_INCREMENT,' .
            Config::ACCESSCONTROL_FILTER_TYPE . ' VARCHAR(255) NOT NULL UNIQUE, ' .
            Config::ACCESSCONTROL_FILTER_LIST . ' VARCHAR(255) NULL,
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
                Config::ACCESSCONTROL_FILTER_TYPE => Config::ACCESSCONTROL_FILTER_IP,
                Config::ACCESSCONTROL_FILTER_LIST => null
            ],
            [
                Config::ACCESSCONTROL_FILTER_TYPE => Config::ACCESSCONTROL_FILTER_USERAGENT,
                Config::ACCESSCONTROL_FILTER_LIST => null
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
