<?php

declare(strict_types=1);

namespace App\Model;

use Anskh\PhpWeb\Model\DbModel;

class Guest extends DbModel
{
    protected string $table = 'guest';
    protected bool $autoIncrement = true;
    protected string $primaryKey = 'id';
    protected array $fields = [
        'nama','asal','keperluan','email','hp','tanggal','foto'
    ];

    public int $id;
    public string $nama;
    public string $asal;
    public string $keperluan;
    public ?string $email = null;
    public string $hp;
    public int $tanggal;
    public ?string $foto;

    public static function table(): string
    {
        return 'guest';
    }

}
 