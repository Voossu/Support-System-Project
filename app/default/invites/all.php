<?php

if (empty($_USER)) {
    move_to(DEFAULT_URL."user/login");
}

if ($_USER['user_level'] < 2) {
    move_to(HOME_URL);
}

if (count($_ROUTING['params']) > 2) {
    move_to(HOME_URL."invites/all");
}

$count = $_ROUTING['params'][0] ?? 15;
$page = $_ROUTING['params'][1] ?? 1;

if (!is_numeric($count) || !is_numeric($page)) {
    move_to(HOME_URL."invites/all");
}

use lib\model\Users;
use lib\model\Invites;

$invites = Invites::get_invites_page_by_get_users($_USER['user_id'], $count, $page);

$invites_page = [];

foreach($invites as $invite) {
    $user = empty($invite['invite_reg_user']) ? null : Users::get_user($invite['invite_reg_user']);
    $invites_page[] = [
        'invite_id' => $invite['invite_id'],
        'invite_code' => $invite['invite_code'],
        'invite_date' => $invite['invite_date'],
        'invite_disabled' => $invite['invite_disabled'],
        'register_user' => empty($invite['invite_reg_user']) ? [] : [
            'info' => "&lt;{$user['user_email']}&gt;",
            'user_url' => HOME_URL."users/{$user['user_id']}"
        ],
        'disable_url' => empty($invite['invite_reg_user'])
            ? HOME_URL."invites/{$invite['invite_id']}/disable?goto=".HOME_URL."invites/all/{$count}/{$page}"
            : "",
        'enable_url' => empty($invite['invite_reg_user'])
            ? HOME_URL."invites/{$invite['invite_id']}/enable?goto=".HOME_URL."invites/all/{$count}/{$page}"
            : "",
    ];
}

$page_count = Invites::get_invites_page_count_by_get_users($_USER['user_id'], $count);

$pages = [];

if ($page_count > 1) {

    $pages['left'] = $page > 1 ? [
        'href' => HOME_URL."invites/all/{$count}/".($page - 1),
        'disabled' => false
    ] : [
        'href' => "",
        'disabled' => true
    ];

    $start_page = null;
    $end_page = null;

    if ($page - 3 > 0) {
        if ($page + 3 > $page_count) {
            $start_page = $page_count - 5;
            $end_page = $page_count;
        } else {
            $start_page = $page - 3;
            $end_page = $start_page + 5;
        }
    } else {
        $start_page = 0;
        $end_page = $page_count < 5 ? $page_count : $start_page + 5;
    }

    for ($i = $start_page + 1; $i < $end_page + 1; $i++) {
        $pages['list'][] = [
            'number' => $i,
            'href'   => HOME_URL."invites/all/{$count}/{$i}",
            'active' => $i == $page
        ];
    }

    $pages['right'] = $page < $page_count ? [
        'href' => HOME_URL."invites/all/{$count}/".($page + 1),
        'disabled' => false
    ] : [
        'href' => "",
        'disabled' => true
    ];

}

View::render("page", [
    'title' => $_LANG['invites']['title'] . " - " . $_CONFIG['system']['site_name'],
    'content' => View::render("menu", [
        'title' => $_LANG['invites']['title'],
        'content' => View::render("default/invites/all", [
            'new' => [
                'href' => HOME_URL."invites/new",
                'title' => $_LANG['invites']['new']['title']
            ],
            'invites' => $invites_page,
            'pages' => $pages
        ])
    ])
])->display();