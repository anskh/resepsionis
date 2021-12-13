<?php

declare(strict_types=1);

use Core\Config\Constants;
use Core\Db\Migration;
use Core\Http\Session\Session;

class m0001_user extends Migration
{
    protected string $table = 'user';

    public function up(): bool
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . db_table($this->table) . '(
            id INT(11) NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            token VARCHAR(255) NOT NULL,
            roles VARCHAR(255) NOT NULL,
            create_at INT(11) NOT NULL,
            update_at INT(11) NULL,
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
            'name'=>'Anas',
            'email'=>'khaerulanas@bps.go.id',
            'password'=>password_hash('123', Constants::HASHING_ALGORITHM),
            'token'=>Session::generateToken(),
            'roles'=>'admin|user',
            'create_at'=> time()
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