<?php

declare(strict_types=1);

namespace App\Model;

use Anskh\PhpWeb\Model\FormModel;

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
        'nama' => [self::ATTR_RULE_REQUIRED, [self::ATTR_RULE_MIN_LENGTH, 3]],
        'asal' => [self::ATTR_RULE_REQUIRED, [self::ATTR_RULE_MIN_LENGTH, 3]],
        'keperluan' => [self::ATTR_RULE_REQUIRED, [self::ATTR_RULE_MIN_LENGTH, 4]],
        'hp' => [self::ATTR_RULE_REQUIRED, [self::ATTR_RULE_MIN_LENGTH , 10], [self::ATTR_RULE_MAX_LENGTH, 15], self::ATTR_RULE_NUMERIC],
        'admin_edit_guest_csrf'=> self::ATTR_RULE_CSRF
    ];
}