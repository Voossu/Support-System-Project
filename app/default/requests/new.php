<?php

if (empty($_USER)) {
    move_to(DEFAULT_URL."user/login");
}

$incomplete_profile =
    empty($_USER['user_firstname']) ||
    empty($_USER['user_lastname']) ||
    empty($_USER['user_phone']) ||
    empty($_USER['user_post']) ||
    empty($_USER['user_division']);

if ($incomplete_profile) {
    move_to(DEFAULT_URL."requests");
}

$params_exist = !empty($_ROUTING['params']) && is_array($_ROUTING['params']);

$is_handler = $params_exist && $_ROUTING['params'][0] === "handler";

if ($params_exist && !$is_handler) {
    move_to(DEFAULT_URL."requests/new");
}

use lib\model\Divisions;
use lib\model\Requests;

if ($is_handler) {
    if (empty($_POST['title'])) {
        $_SESSION['new']['errors'][] = $_LANG['requests']['title_no_set'];
    }
    if (empty($_POST['division'])) {
        $_SESSION['new']['errors'][] = $_LANG['requests']['division_no_set'];
    }
    if (empty($_SESSION['new']['errors'])) {
        Requests::new_request($_POST['title'], $_POST['description'], $_USER['user_id'], $_POST['division']);
        move_to(HOME_URL."requests/my");
    } else {
        $_SESSION['new']['values'] = $_POST;
        move_to(HOME_URL."requests/new");
    }

} else {
    View::render("page", [
        'title' => $_LANG['requests']['new']['title'] . " - " . $_CONFIG['system']['site_name'],
        'content' => View::render("menu", [
            'title' => $_LANG['requests']['new']['title'],
            'content' => View::render("default/requests/new", [
                'new_errors' => $_SESSION['new']['errors'] ?? [],
                'new_action' => HOME_URL . "requests/new/handler",
                'new_method' => "post",
                'fields' => [
                    'title' => [
                        'name' => "title",
                        'length' => 64,
                        'value' => $_SESSION['new']['values']['title'] ?? ""
                    ],
                    'description' => [
                        'name' => "description",
                        'length' => 256,
                        'value' => $_SESSION['new']['values']['description'] ?? ""
                    ],
                    'division' => [
                        'name' => "division",
                        'value' => $_SESSION['new']['values']['division'] ?? "",
                        'values' => Divisions::get_all_divisions()
                    ]
                ]
            ])
        ])
    ])->display();
    unset($_SESSION['new']);
}

