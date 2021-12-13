<?php

declare(strict_types=1);

namespace App\Model;

use Core\Model\FormModel;

class EditGuestFormAdmin extends FormModel
{
    public int $id;
    public string $nama;
    public string $asal;
    public string $keperluan;
    public string $admin_edit_guest_csrf;
    public ?string $email = null;
    public string $hp;

    protected array $labels = [
        'nama' => 'Nama Pengunjung <span class="text-danger">*</span>',
        'asal' => 'Asal Kementerian/Lembaga/Instansi/Sekolah/Daerah <span class="text-danger">*</span>',
        'keperluan' => 'Keperluan Kunjungan <span class="text-danger">*</span>',
        'email' => 'Alamat email',
        'hp' => 'Nomor HP <span class="text-danger">*</span>'
    ];

    protected array $rules = [
        'nama' => [self::RULE_REQUIRED, [self::RULE_MIN_LENGTH, 3]],
        'asal' => [self::RULE_REQUIRED, [self::RULE_MIN_LENGTH, 3]],
        'keperluan' => [self::RULE_REQUIRED, [self::RULE_MIN_LENGTH, 4]],
        'hp' => [self::RULE_REQUIRED, [self::RULE_MIN_LENGTH , 10], [self::RULE_MAX_LENGTH, 15], self::RULE_NUMERIC],
        'admin_guest_csrf'=> self::RULE_CSRF
    ];
}