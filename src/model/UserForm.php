<?php

declare(strict_types=1);

namespace App\Model;

use Core\Model\FormModel;

class UserForm extends FormModel
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $roles;
    public string $user_csrf;

    protected array $labels = [
        'name' => 'Nama <span class="text-danger">*</span>',
        'email' => 'Alamat email <span class="text-danger">*</span>',
        'password' => 'Password <span class="text-danger">*</span>',
        'roles' => 'Peran Pengguna (user, admin, user|admin, admin|user) <span class="text-danger">*</span>',
    ];

    protected array $rules = [
        'name' => [self::RULE_REQUIRED, [self::RULE_MIN_LENGTH, 3]],
        'email' => [self::RULE_EMAIL,[self::RULE_UNIQUE, 'user', 'email']],
        'password' => self::RULE_REQUIRED,
        'roles' => [self::RULE_REQUIRED, [self::RULE_IN_LIST, ['user','admin','user|admin','admin|user']]],
        'user_csrf' => self::RULE_CSRF
    ];
}