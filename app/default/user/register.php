<?php

if (!empty($_USER)) {
    die("404");
}

$params_exist = !empty($_ROUTING['params']) && is_array($_ROUTING['params']);

$is_handler = $params_exist && $_ROUTING['params'][0] === "handler";

if ($params_exist && !$is_handler) {
    move_to(HOME_URL."user/register");
}

use lib\model\Invites;
use lib\model\Users;

if ($is_handler) {

    if (empty($_POST['email']) && empty($_POST['invite'])) {
        move_to(HOME_URL."user/register");
    }
    if (!preg_match("/{$_CONFIG['regexp']['email']}/", $_POST['email'])) {
        $_SESSION['register']['errors'][] = $_LANG['users']['email_format_error'];
    } elseif(!empty(Users::get_user_by_email($_POST['email']))) {
        $_SESSION['register']['errors'][] = $_LANG['users']['user_exist'];
    }
    if (!preg_match("/{$_CONFIG['regexp']['invite']}/", $_POST['invite'])) {
        $_SESSION['register']['errors'][] = $_LANG['users']['invite_format_error'];
    } else {
        $invite = Invites::get_invite_by_code($_POST['invite']);
        if (empty($invite)) {
            $_SESSION['register']['errors'][] = $_LANG['users']['register']['invite_not_exist'];
        }
        if (empty($_SESSION['register']['errors'])) {
            $_DATABASE->beginTransaction();
            $pass = uniqid();
            $user_id = Users::new_user($_POST['email'], password_hash($pass, PASSWORD_DEFAULT));
            Invites::activate_invite($invite['invite_id'], $user_id);
            if ($_DATABASE->commit()) {
                $subject = $_LANG['users']['register']['email_subject'];
                $message = $_LANG['users']['register']['email_register'];

                send_mail($_POST['email'],
                    str_insert($_LANG['users']['register']['email_subject'], [
                            'site_name' => $_CONFIG['site_name']
                        ]),
                    str_insert($_LANG['users']['register']['email_register'], [
                            'user_pass' => $pass
                        ])
                );
                move_to(HOME_URL."user/login");
            } else {
                $_SESSION['register']['errors'][] = $_LANG['users']['register']['register_failed'];
            };
        }
    }
    $_SESSION['register']['options'] = $_POST;
    move_to(HOME_URL."user/register");

} else {

    View::render("page", [
        'title' => $_LANG['users']['register']['title'] . " - " . $_CONFIG['system']['site_name'],
        'content' => View::render("menu", [
            'title' => $_LANG['users']['register']['title'],
            'content' => View::render("default/user/register", [
                'register_errors' => $_SESSION['register']['errors'] ?? [],
                'register_action' => HOME_URL . "user/register/handler",
                'register_method' => "post",
                'fields' => [
                    'email' => [
                        'name' => "email",
                        'length' => 64,
                        'value' => $_SESSION['register']['options']['email'] ?? ""
                    ],
                    'invite' => [
                        'name' => "invite",
                        'length' => 16,
                        'value' => $_SESSION['register']['options']['invite'] ?? ""
                    ]
                ]
            ])
        ])
    ])->display();

    unset($_SESSION['register']);

}