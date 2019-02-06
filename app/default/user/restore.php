<?php

use lib\model\Users;

if (!empty($_USER)) {
    die("404");
}

$params_exist = !empty($_ROUTING['params']) && is_array($_ROUTING['params']);

$is_handler = $params_exist && $_ROUTING['params'][0] === "handler";

if ($params_exist && !$is_handler) {
    move_to(HOME_URL."user/restore");
}

$params_exist = !empty($_ROUTING['params']) && is_array($_ROUTING['params']);

$is_handler = $params_exist && $_ROUTING['params'][0] === "handler";

if ($params_exist && !$is_handler) {
    move_to(HOME_URL."user/register");
}

if ($is_handler) {

    if (empty($_POST['email'])) {
        move_to(HOME_URL."user/restore");
    }
    if (!preg_match("/{$_CONFIG['regexp']['email']}/", $_POST['email'])) {
        $_SESSION['restore']['errors'][] = $_LANG['users']['email_format_error'];
    }
    if (!empty($_SESSION['restore']['errors'])) {
        $_SESSION['register']['options'] = $_POST;
        move_to(HOME_URL."user/restore");
    }


} else {

    View::render("page", [
        'title' => $_LANG['users']['restore']['title'] . " - " . $_CONFIG['system']['site_name'],
        'content' => View::render("menu", [
            'title' => $_LANG['users']['restore']['title'],
            'content' => View::render("default/user/restore", [
            'restore_errors' => $_SESSION['restore']['errors'] ?? [],
            'restore_action' => HOME_URL . "user/restore/handler",
            'restore_method' => "post",
            'fields' => [
                'email' => [
                    'name' => "email",
                    'length' => 64,
                    'value' => $_SESSION['restore']['options']['email'] ?? ""
                ]
            ]
            ])
        ])
    ])->display();
    unset($_SESSION['restore']);

}
