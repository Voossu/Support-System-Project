<?php

if (!empty($_USER)) {
    die("404");
}

$params_exist = !empty($_ROUTING['params']) && is_array($_ROUTING['params']);

$is_handler = $params_exist && $_ROUTING['params'][0] === "handler";

if ($params_exist && !$is_handler) {
    move_to(DEFAULT_URL."user/login");
}

use lib\model\Users;
use lib\model\Sessions;

if ($is_handler) {

    if (empty($_POST['email']) && empty($_POST['email'])) {
        move_to(HOME_URL."user/login");
    }
    if (!preg_match("/{$_CONFIG['regexp']['email']}/", $_POST['email'])) {
        $_SESSION['login']['errors'][] = $_LANG['users']['email_format_error'];
    }
    if (!preg_match("/{$_CONFIG['regexp']['pass']}/", $_POST['pass'])) {
        $_SESSION['login']['errors'][] = $_LANG['users']['pass_format_error'];
    }
    if (empty($_SESSION['login']['errors'])) {
        $user = Users::get_user_by_email($_POST['email']);
        if (!empty($user) && password_verify($_POST['pass'], $user['user_pass'])) {
            if ($user['user_locked'] == 1) {
                $_SESSION['login']['errors'][] = $_LANG['users']['login']['user_block'];
            } else {
                Sessions::start_session_for_user($user['user_id']);
                move_to(HOME_URL);
            }
        } else {
            $_SESSION['login']['errors'][] = $_LANG['users']['login']['login_failed'];
        }
    }
    $_SESSION['login']['options'] = $_POST;
    move_to(HOME_URL."user/login");

} else {

    View::render("page", [
        'title' => $_LANG['users']['login']['title'] . " - " . $_CONFIG['system']['site_name'],
        'content' => View::render("menu", [
            'title' => $_LANG['users']['login']['title'],
            'content' => View::render("default/user/login", [
                'login_errors' => $_SESSION['login']['errors'] ?? [],
                'login_action' => HOME_URL . "user/login/handler",
                'login_method' => "post",
                'fields' => [
                    'email' => [
                        'name' => "email",
                        'length' => 64,
                        'value' => $_SESSION['login']['options']['email'] ?? ""
                    ],
                    'pass' => [
                        'name' => "pass",
                        'length' => 64,
                        'value' => ""
                    ]
                ]
            ])
        ])
    ])->display();
    unset($_SESSION['login']);

}