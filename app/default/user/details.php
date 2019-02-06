<?php

if (empty($_USER)) {
    move_to(DEFAULT_URL."user/login");
}

use lib\model\Users;
use lib\model\Invites;

$params_exist = !empty($_ROUTING['params']) && is_array($_ROUTING['params']);

if ($params_exist) {
    move_to(HOME_URL."user/details");
}

$details_menu = [
    [
        'title'  => $_LANG['users']['profile']['title'],
        'url'    => HOME_URL."user/profile",
    ],
    [
        'title' => $_LANG['users']['details']['title'],
        'url'   => HOME_URL."user/details",
        'select' => true
    ],
    [
        'title' => $_LANG['users']['sessions']['title'],
        'url'   => HOME_URL."user/sessions"
    ]
];

$invite = Invites::get_user_invite($_USER['user_id']);
$invite_get_user = Users::get_user($invite['invite_get_user']);


View::render("page", [
    'title' => $_LANG['users']['details']['title'] . " - " . $_CONFIG['system']['site_name'],
    'content' => View::render("menu", [
        'title' => $_LANG['users']['details']['title'],
        'content' => View::render("default/user/details", [
            'menu' => $details_menu,
            'user' => $_USER,
            'invite' => [
                'get_user' => empty($invite_get_user)
                    ? "system"
                    : "&lt;{$invite_get_user['user_email']}&gt; "
                    . (!empty($invite_get_user['user_firstname']) ? $invite_get_user['user_firstname'] ." " : "")
                    . (!empty($invite_get_user['user_secondname']) ? $invite_get_user['user_secondname'] . " " : "")
                    . (!empty($invite_get_user['user_lastname']) ? $invite_get_user['user_lastname'] : ""),
                'date' => $invite['invite_date']
            ]
        ])
    ])
])->display();