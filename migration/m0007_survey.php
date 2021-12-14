<?php

declare(strict_types=1);

use PhpWeb\Db\Migration;

use function PhpWeb\app;

class m0007_survey extends Migration
{
    protected string $table = 'survey';

    public function up(): bool
    {
        $db = app()->db($this->connection);
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $db->table($this->table) . '(
            id INT(11) NOT NULL AUTO_INCREMENT, 
            selected INT NOT NULL DEFAULT 4,
            feedback VARCHAR(255) NULL,
            create_at INT(11) NOT NULL, 
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