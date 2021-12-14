<?php

declare(strict_types=1);

use PhpWeb\Config\Config;
use PhpWeb\Db\Migration;

use function PhpWeb\app;

class m0006_assignment extends Migration
{
    protected string $table = Config::ATTR_ACCESSCONTROL_ASSIGNMENT;

    public function up(): bool
    {
        $db = app()->db($this->connection);
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $db->table($this->table) . '(
            id INT(11) NOT NULL AUTO_INCREMENT, ' .
            Config::ATTR_ACCESSCONTROL_ROLE . ' VARCHAR(255) NOT NULL UNIQUE, ' .
            Config::ATTR_ACCESSCONTROL_PERMISSION . ' VARCHAR(255) NULL,
            PRIMARY KEY (id)
        )ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;';

        try
        {
            $db->connection()->exec($sql);
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