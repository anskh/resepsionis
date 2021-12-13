<?php

declare(strict_types=1);

use Core\Config\Constants;
use Core\Db\Migration;

class m0005_filter extends Migration
{
    protected string $table = Constants::ACCESS_FILTER;

    public function up(): bool
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . db_table($this->table) . '(
            id INT(11) NOT NULL AUTO_INCREMENT,'. 
            Constants::ACCESS_FILTER_TYPE . ' VARCHAR(255) NOT NULL UNIQUE, ' .
            Constants::ACCESS_FILTER_LIST . ' VARCHAR(255) NULL,
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
                Constants::ACCESS_FILTER_TYPE=>Constants::ACCESS_FILTER_IP,
                Constants::ACCESS_FILTER_LIST=> null
            ],
            [
                Constants::ACCESS_FILTER_TYPE=>Constants::ACCESS_FILTER_USER_AGENT,
                Constants::ACCESS_FILTER_LIST=>null
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