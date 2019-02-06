<?php

if (empty($_GET['q']) || count($_ROUTING['params']) > 2) {
    move_to(HOME_URL."users/all");
}

$count = $_ROUTING['params'][0] ?? 15;
$page = $_ROUTING['params'][1] ?? 1;

if (!is_numeric($count) || !is_numeric($page)) {
    move_to(HOME_URL."users/all");
}

use lib\model\Users;
use lib\model\Divisions;

$users = Users::get_users_search($count, $page, $_GET['q']);

$users_page = [];


foreach ($users as $user) {
    $users_page[] = [
        'user_email' => $user['user_email'],
        'user_level' => $_LANG['users']['levels'][$user['user_level'] - 1],
        'user_work'  => $user['user_post'] . (empty($user['user_division']) ? "" : (", " . Divisions::get_division($user['user_division'])['division_name'])),
        'user_fullname' => (!empty($user['user_firstname']) ? $user['user_firstname'] ." " : "")
            . (!empty($user['user_secondname']) ? $user['user_secondname'] . " " : "")
            . (!empty($user['user_lastname']) ? $user['user_lastname'] : ""),
        'user_profile_href' => HOME_URL."users/{$user['user_id']}"
    ];
}

$page_count = Users::get_page_search_count($count, $_GET['q']);

$pages = [];

if ($page_count > 1) {

    $pages['left'] = $page > 1 ? [
        'href' => HOME_URL."users/search/{$count}/".($page - 1)."?q=".$_GET['q'],
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
            'href'   => HOME_URL."users/search/{$count}/{$i}?q=".$_GET['q'],
            'active' => $i == $page
        ];
    }

    $pages['right'] = $page < $page_count ? [
        'href' => HOME_URL."users/search/{$count}/".($page + 1)."?q=".$_GET['q'],
        'disabled' => false
    ] : [
        'href' => "",
        'disabled' => true
    ];

}

View::render("page", [
    'title' => $_LANG['users']['users']['title'] . " - " . $_CONFIG['system']['site_name'],
    'content' => View::render("menu", [
        'title' => $_LANG['users']['users']['title'],
        'content' => View::render("admin/users/search", [
            'search' => [
                'handler' => HOME_URL."users/search/{$count}",
                'method' => "get",
                'field' => "q",
                'value' => $_GET['q']
            ],
            'users' => $users_page,
            'pages' => $pages
        ])
    ])
])->display();