<?php

declare(strict_types=1);

use PhpWeb\Config\Config;

return [
    // list of route name which needs auth
    Config::ATTR_ACCESSCONTROL_PERMISSION => [
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
    Config::ATTR_ACCESSCONTROL_ROLE => [
        'admin',
        'user'
    ],
    // mapping role with permission
    // role => [permission1, permission2]
    Config::ATTR_ACCESSCONTROL_ASSIGNMENT => [
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
    Config::ATTR_ACCESSCONTROL_FILTER => [
        Config::ACCESSCONTROL_FILTER_IP => [],
        Config::ACCESSCONTROL_FILTER_USERAGENT => []
    ]
];