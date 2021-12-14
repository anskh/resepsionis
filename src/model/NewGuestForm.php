<?php

declare(strict_types=1);

namespace App\Model;

use PhpWeb\Model\FormModel;

class NewGuestForm extends FormModel
{
    public int $id;
    public string $nama;
    public string $asal;
    public string $keperluan;
    public ?string $email = null;
    public string $hp;
    public ?string $foto=null;
    public string $create_guest_csrf;

}