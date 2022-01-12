<?php

declare(strict_types=1);

namespace App\Model;

use Anskh\PhpWeb\Model\FormModel;

class EditUserForm extends FormModel
{
    public int $id;
    public string $name;
    public string $email;
    public string $roles;
    public string $user_csrf;

    protected array $labels = [
        'name' => 'Nama <span class="text-danger">*</span>',
        'email' => 'Alamat email <span class="text-danger">*</span>',
        'password' => 'Password <span class="text-danger">*</span>',
        'roles' => 'Peran Pengguna (user, admin, user|admin, admin|user) <span class="text-danger">*</span>',
    ];
}