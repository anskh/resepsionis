<?php

declare(strict_types=1);

use PhpWeb\Db\Migration;

use function PhpWeb\app;

class m0002_guest extends Migration
{
    protected string $table = 'guest';

    public function up(): bool
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . app()->db()->table($this->table) . '(
            id INT(11) NOT NULL AUTO_INCREMENT,
            nama VARCHAR(255) NOT NULL,
            asal VARCHAR(255) NOT NULL,
            keperluan VARCHAR(255) NOT NULL,
            email VARCHAR(255) NULL,
            hp VARCHAR(255) NOT NULL,
            tanggal INT(11) NOT NULL,
            foto text NULL,
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
            [
                'nama'=>'Qurrota Aini',
                'asal'=>'SMKN 1 Rambah',
                'keperluan'=>'Mengantar anak magang',
                'email'=> null,
                'hp'=>'082169354373',
                'tanggal'=>strtotime('2021-01-12 10:21:07'),
                'foto'=> null
            ],
            [
                'nama'=>'Yulinar',
                'asal'=>'Bappeda',
                'keperluan'=>'Permintaan data',
                'email'=> null,
                'hp'=>'082273053914',
                'tanggal'=>strtotime('2021-01-15 11:01:47'),
                'foto'=> null
            ],
            [
                'nama'=>'Iis Giyati',
                'asal'=>'Desa Sialang Rindang',
                'keperluan'=>'Permintaan data',
                'email'=> null,
                'hp'=>'085271647425',
                'tanggal'=>strtotime('2021-01-18 14:41:04'),
                'foto'=> null
            ]
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