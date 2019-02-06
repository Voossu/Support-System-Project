<?php

if (empty($_USER)) {
    move_to(DEFAULT_URL."user/login");
}

if ($_USER['user_level'] < 2) {
    move_to(HOME_URL);
}

$params_exist = !empty($_ROUTING['params']) && is_array($_ROUTING['params']);

$is_handler = $params_exist && $_ROUTING['params'][0] === "handler";

if ($params_exist && !$is_handler) {
    move_to(HOME_URL."invites/all");
}

use lib\model\Invites;

$new_invites = [];

if ($is_handler) {
    for ($i = 0; $i < $_POST['count']; $i++) {
        $code = str_rand(16);
        if (Invites::new_invite($code, $_USER['user_id'])) {
            $new_invites[] = $code;
        }

    }
}

View::render("page", [
    'title' => $_LANG['invites']['new']['title'] . " - " . $_CONFIG['system']['site_name'],
    'content' => View::render("menu", [
        'title' => $_LANG['invites']['new']['title'],
        'content' => View::render("default/invites/new", [
            'all' => [
                'href' => HOME_URL . "invites/all",
                "title" => $_LANG['invites']['all_invites']
            ],
            'new_action' => HOME_URL . "invites/new/handler",
            'new_method' => "post",
            'fields' => [
                'count' => [
                    'name' => "count",
                    'value' => 1
                ]
            ],
            'new_invites' => $new_invites
        ])
    ])
])->display();