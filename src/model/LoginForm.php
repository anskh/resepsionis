<?php

declare(strict_types=1);

namespace App\Model;

use PhpWeb\Model\FormModel;

class LoginForm extends FormModel
{
    public string $email;
    public string $password;
    public string $logincsrf;

    protected array $labels = [
        'email' => 'Alamat Email <span class="text-danger">*</span>',
        'password' => 'Kata Sandi <span class="text-danger">*</span>'
    ];

    protected array $rules = [
        'email' => self::ATTR_RULE_EMAIL,
        'password' => self::ATTR_RULE_REQUIRED,
        'logincsrf' => self::ATTR_RULE_CSRF
    ];
}