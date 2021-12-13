<?php

declare(strict_types=1);

use Core\Config\Constants;
use Core\Db\Migration;

class m0004_permission extends Migration
{
    protected string $table = Constants::ACCESS_PERMISSION;

    public function up(): bool
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . db_table($this->table) . '(
            id INT(11) NOT NULL AUTO_INCREMENT,' .
            Constants::ACCESS_PERMISSION_NAME . ' VARCHAR(255) NOT NULL UNIQUE,
            PRIMARY KEY (id)
        )ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;';

        try
        {
            app()->db()->exec($sql);
        }catch(Exception $e){
            return false;
        }
         
        return true;
    }

    public function seed(): bool
    {
        return false;
    }
}