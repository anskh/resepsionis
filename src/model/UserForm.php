<?php

declare(strict_types=1);

namespace App\Model;

use PhpWeb\Model\FormModel;

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
        'name' => [self::ATTR_RULE_REQUIRED, [self::ATTR_RULE_MIN_LENGTH, 3]],
        'email' => [self::ATTR_RULE_EMAIL,[self::ATTR_RULE_UNIQUE, 'user', 'email']],
        'password' => self::ATTR_RULE_REQUIRED,
        'roles' => [self::ATTR_RULE_REQUIRED, [self::ATTR_RULE_IN_LIST, ['user','admin','user|admin','admin|user']]],
        'user_csrf' => self::ATTR_RULE_CSRF
    ];
}