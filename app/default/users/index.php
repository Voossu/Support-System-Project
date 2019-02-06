<?php

if (empty($_USER)) {
    move_to(DEFAULT_URL."user/login");
}

use lib\model\Requests;

if (count($_ROUTING['params']) !== 1 || !is_numeric($_ROUTING['params'][0])) {
    move_to(HOME_URL."users/all");
}


if ($_USER['user_level'] < 2 && Requests::is_request_executor($_USER['user_level'], $_ROUTING['params'][0])) {
    move_to(HOME_URL);
}

use lib\model\Users;
use lib\model\Divisions;

$user = Users::get_user($_ROUTING['params'][0]);

$user_page = [];

if (!empty($user)) {
    $user_page = [
        'user_fullname' => (!empty($user['user_firstname']) ? $user['user_firstname'] . " " : "")
            . (!empty($user['user_secondname']) ? $user['user_secondname'] . " " : "")
            . (!empty($user['user_lastname']) ? $user['user_lastname'] : ""),
        'user_work' => $user['user_post'] . (empty($user['user_division']) ? "" : (", " . Divisions::get_division($user['user_division'])['division_name'])),
        'user_email' => $user['user_email'],
        'user_phone' => $user['user_phone'],
        'user_level' => $_LANG['users']['levels'][$user['user_level'] - 1]
    ];
}

View::render("page", [
    'title' => $_LANG['users']['profile']['title'] . " - " . $_CONFIG['system']['site_name'],
    'content' => View::render("menu", [
        'title' => $_LANG['users']['profile']['title'],
        'content' => View::render("default/users/user", [
            'all_users_url' => $_USER['user_level'] < 2 ? null : HOME_URL."users/all",
            'user' => $user_page
        ])
    ])
])->display();