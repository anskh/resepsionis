<?php

declare(strict_types=1);

use Core\Config\Constants;
use Core\Db\Migration;

class m0003_role extends Migration
{
    protected string $table = Constants::ACCESS_ROLE;

    public function up(): bool
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . db_table($this->table) . '(
            id INT(11) NOT NULL AUTO_INCREMENT,' .
            Constants::ACCESS_ROLE_NAME . ' VARCHAR(255) NOT NULL UNIQUE,
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
        $data = [
            [
                Constants::ACCESS_ROLE_NAME=>'admin'
            ],
            [
                Constants::ACCESS_ROLE_NAME=>'user'
            ]
        ];
        
        try
        {
            db_insert($data, db_table($this->table));
        }catch(Exception $e){
            return false;
        }
         
        return true;
    }
}