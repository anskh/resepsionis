<?php

declare(strict_types=1);

use Core\Config\Constants;
use App\Model\User;

return [
    // list of route name which needs auth
    Constants::ACCESS_PERMISSION => [
        'admin',
        'admin_list_guest',
        'admin_view_guest',
        'admin_create_guest',
        'admin_remove_guest',
        'admin_list_user',
        'admin_view_user',
        'admin_create_user',
        'admin_remove_user',
        'admin_list_survey',
        'admin_remove_survey'
    ],
    // list of available role
    Constants::ACCESS_ROLE => [
        'admin',
        'user'
    ],
    // mapping role with permission
    // role => [permission1, permission2]
    Constants::ACCESS_ASSIGNMENT => [
        'admin'=>[
            'admin',
            'admin_list_user',
            'admin_view_user',
            'admin_create_user',
            'admin_remove_user'
        ],
        'user'=>[
            'admin',
            'admin_list_guest',
            'admin_view_guest',
            'admin_create_guest',
            'admin_remove_guest',
            'admin_list_survey',
            'admin_remove_survey'
        ]
    ],
    // list of filter by specific attribute
    // deny if in list
    Constants::ACCESS_FILTER => [
        Constants::ACCESS_FILTER_IP => [],
        Constants::ACCESS_FILTER_USER_AGENT => []
    ]
];