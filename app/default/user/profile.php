<?php

if (empty($_USER)) {
    move_to(DEFAULT_URL."user/login");
}

$params_exist = !empty($_ROUTING['params']) && is_array($_ROUTING['params']);

$is_handler = $params_exist && $_ROUTING['params'][0] === "handler";

if ($params_exist && !$is_handler) {
    move_to(HOME_URL."user/profile");
}

use lib\model\Users;
use lib\model\Divisions;

$profile_menu = [
    [
        'title'  => $_LANG['users']['profile']['title'],
        'url'    => HOME_URL."user/profile",
        'select' => true
    ],
    [
        'title' => $_LANG['users']['details']['title'],
        'url'   => HOME_URL."user/details"
    ],
    [
        'title' => $_LANG['users']['sessions']['title'],
        'url'   => HOME_URL."user/sessions"
    ]
];

if ($is_handler) {

    if (!empty($_POST['pass']) || !empty($_POST['newpass'])) {

        if (!preg_match("/{$_CONFIG['regexp']['pass']}/", $_POST['pass'])) {
            $_SESSION['profile']['errors'][] = $_LANG['users']['pass_format_error'];
        } elseif (!password_verify($_POST['pass'], $_USER['user_pass'])) {
            $_SESSION['profile']['errors'][] = $_LANG['users']['pass_error'];
        }

        if (!preg_match("/{$_CONFIG['regexp']['pass']}/", $_POST['newpass'])) {
            $_SESSION['profile']['errors'][] = $_LANG['users']['newpass_format_error'];
        }

        if (empty($_SESSION['profile']['errors'])) {
            Users::update_user($_USER['user_id'], password_hash($_POST['newpass'], PASSWORD_DEFAULT),
                $_POST['firstname'], $_POST['secondname'], $_POST['lastname'],
                empty($_POST['division']) ? null : $_POST['division'], $_POST['post'], $_POST['phone'],
                $_USER['user_locked'], $_USER['user_level']);
        } else {
            Users::update_user($_USER['user_id'], $_USER['user_pass'],
                $_POST['firstname'], $_POST['secondname'], $_POST['lastname'],
                empty($_POST['division']) ? null : $_POST['division'], $_POST['post'], $_POST['phone'],
                $_USER['user_locked'], $_USER['user_level']);

            $_SESSION['profile']['options']['pass'] = $_POST['pass'];
            $_SESSION['profile']['options']['newpass'] = $_POST['newpass'];
        }

    } else {
        Users::update_user($_USER['user_id'], $_USER['user_pass'],
            $_POST['firstname'], $_POST['secondname'], $_POST['lastname'],
            empty($_POST['division']) ? null : $_POST['division'], $_POST['post'], $_POST['phone'],
            $_USER['user_locked'], $_USER['user_level']);
    }

    move_to(HOME_URL."user/profile/edit");

} else {

    $list = Divisions::get_all_divisions();

    View::render("page", [
        'title' => $_LANG['users']['profile']['title'] . " - " . $_CONFIG['system']['site_name'],
        'content' => View::render("menu", [
            'title' => $_LANG['users']['profile']['title'],
            'content' => View::render("default/user/profile", [
                'menu' => $profile_menu,
                'user' => $_USER,
                'profile_errors' => $_SESSION['profile']['errors'] ?? [],
                'profile_action' => HOME_URL . "user/profile/handler",
                'profile_method' => "post",
                'fields' => [
                    'id' => [
                        'name' => "id"
                    ],
                    'email' => [
                        'name' => "email",
                        'length' => 64
                    ],
                    'firstname' => [
                        'name' => "firstname",
                        'length' => 16
                    ],
                    'secondname' => [
                        'name' => "secondname",
                        'length' => 16
                    ],
                    'lastname' => [
                        'name' => "lastname",
                        'length' => 16
                    ],
                    'division' => [
                        'name' => "division",
                        'empty' => null,
                        'list' => $list
                    ],
                    'post' => [
                        'name' => "post",
                        'length' => 16
                    ],
                    'phone' => [
                        'name' => "phone",
                        'length' => 16
                    ],
                    'pass' => [
                        'name' => "pass",
                        'length' => 64,
                        'value' => $_SESSION['profile']['options']['pass'] ?? ""
                    ],
                    'newpass' => [
                        'name' => "newpass",
                        'length' => 64,
                        'value' => $_SESSION['profile']['options']['newpass'] ?? ""
                    ]
                ]
            ])
        ])
    ])->display();

    unset($_SESSION['profile']);

}