<?php

declare(strict_types=1);

use App\Model\User;
use PhpWeb\Config\Config;
use PhpWeb\Config\Environment;

return [
    Config::ATTR_APP_NAME => 'Resepsionis BPS',
    Config::ATTR_APP_VERSION => '1.0',
    Config::ATTR_APP_VENDOR => 'BPS Kabupaten Rokan Hulu',
    Config::ATTR_APP_VIEW => [
        Config::ATTR_VIEW_PATH => ROOT . '/src/app/view',
        Config::ATTR_VIEW_FILE_EXT => '.phtml'
    ],
    Config::ATTR_APP_BASEURL => 'http://localhost',
    Config::ATTR_APP_BASEPATH => '/resepsionis',
    Config::ATTR_APP_ENVIRONMENT => Environment::DEVELOPMENT,
    Config::ATTR_APP_ACCESSCONTROL => [
        Config::ATTR_ACCESSCONTROL_DRIVER => Config::ACCESSCONTROL_DRIVER_FILE,
        Config::ACCESSCONTROL_DRIVER_FILE => 'acl',
        Config::ACCESSCONTROL_DRIVER_DB => 'mysql',
        Config::ATTR_ACCESSCONTROL_MODEL => User::class
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
