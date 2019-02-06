<?php

$params_exist = !empty($_ROUTING['params']) && is_array($_ROUTING['params']);

$is_handler = $params_exist && $_ROUTING['params'][0] === "handler";

if ($params_exist && !$is_handler) {
    move_to(DEFAULT_URL."divisions/new");
}

use lib\model\Divisions;

if ($is_handler) {
    if (empty($_POST['name'])) {
        $_SESSION['new']['errors'][] = $_LANG['divisions']['title_no_set'];
    }
    if (empty($_SESSION['new']['errors'])) {
        $id = Divisions::new_division($_POST['name'], $_POST['description']);
        move_to(HOME_URL."divisions/{$id}/edit");
    }
    $_SESSION['new']['fields'] = $_POST;
    move_to(HOME_URL."divisions/new");
} else {
    View::render("page", [
        'title' => $_LANG['divisions']['edit']['title'] . " - " . $_CONFIG['system']['site_name'],
        'content' => View::render("menu", [
            'title' => $_LANG['divisions']['edit']['title'],
            'content' => View::render("admin/divisions/new", [
                'new_errors' => $_SESSION['new']['errors'],
                'all_divisions_href' => HOME_URL."divisions/all",
                'new_action' => HOME_URL."divisions/{$division['division_id']}/new/handler",
                'new_method' => "post",
                'fields' => [
                    'name' => [
                        'name' => "name",
                        'length' => 32
                    ],
                    'description' => [
                        'name' => "description",
                        'length' => 256
                    ]
                ]
            ])
        ])
    ])->display();
    unset($_SESSION['new']);
}