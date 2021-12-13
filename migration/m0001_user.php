<?php

declare(strict_types=1);

use PhpWeb\Config\Config;
use PhpWeb\Db\Migration;
use PhpWeb\Http\Session\Session;

use function PhpWeb\app;

class m0001_user extends Migration
{
    protected string $table = 'user';

    public function up(): bool
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . app()->db()->table($this->table) . '(
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
            app()->db()->connection()->exec($sql);
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
            'password'=>password_hash('123', Config::HASHING_ALGORITHM),
            'token'=>Session::generateToken(),
            'roles'=>'admin|user',
            'create_at'=> time()
        ];

        try
        {
            app()->db()->insert($data, $this->table);
        }catch(Exception $e){
            return false;
        }
         
        return true;
    }
}