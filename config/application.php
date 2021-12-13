<?php

declare(strict_types=1);

use App\Model\User;
use Core\Config\Constants;

return [
    'name' => 'Resepsionis BPS',
    'version' => '1.0',
    'vendor' => 'BPS Kabupaten Rokan Hulu',
    'view' => [
        Constants::VIEW_PATH => ROOT . '/src/app/view',
        Constants::VIEW_FILE_EXT => '.phtml'
    ],
    'base_url' => 'http://localhost',
    'base_path' => '/resepsionis',
    'environment' => Constants::DEVELOPMENT,
    'access_control' => [
        Constants::ACCESS_DRIVER => Constants::ACCESS_DRIVER_FILE,
        Constants::ACCESS_DRIVER_FILE => 'acl',
        Constants::ACCESS_DRIVER_DB => 'mysql',
        Constants::ACCESS_MODEL => User::class
    ],
    'config'=>[
        'guest'=>[
            'allow_no_photo' => false
        ],
        'survey'=>[
            'token'=>'385e33f741'
        ]
    ]
];
