<?php

declare(strict_types=1);

namespace App\Model;

use Anskh\PhpWeb\Model\DbModel;

class User extends DbModel
{
    protected string $table = 'user';
    protected bool $autoIncrement = true;
    protected string $primaryKey = 'id';
    protected array $fields = [
        'name','email','password','token','roles','create_at','update_at'
    ];

    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $token;
    public string $roles;
    public int $create_at;
    public int $update_at;

    public static function table(): string
    {
        return 'user';
    }

}
 