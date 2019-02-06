<?php

if (empty($_USER)) {
    move_to(DEFAULT_URL."user/login");
}

if (count($_ROUTING['params']) > 2) {
    move_to(HOME_URL."requests/my");
}

$count = $_ROUTING['params'][0] ?? 15;
$page = $_ROUTING['params'][1] ?? 1;


if (!is_numeric($count) || !is_numeric($page)) {
    move_to(HOME_URL."requests/my");
}

use lib\model\Requests;
use lib\model\Divisions;

$requests_page = Requests::get_requests_by_user($_USER['user_id'], $count, $page);

if ($page !== 1 && empty($requests_page)) {
    move_to(HOME_URL."requests/my");
}

foreach ($requests_page as $key => $request) {
    $requests_page[$key]['href'] = HOME_URL."requests/{$request['request_id']}";
    $requests_page[$key]['request_division'] = Divisions::get_division($request['request_division'])['division_name'];
}

$page_count = Requests::get_user_page_count($_USER['user_id'], $count);

$pages = [];

if ($page_count > 1) {

    $pages['left'] = $page > 1 ? [
        'href' => HOME_URL."requests/my/{$count}/".($page - 1),
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
            'href'   => HOME_URL."requests/my/{$count}/{$i}",
            'active' => $i == $page
        ];
    }

    $pages['right'] = $page < $page_count ? [
        'href' => HOME_URL."requests/my/{$count}/".($page + 1),
        'disabled' => false
    ] : [
        'href' => "",
        'disabled' => true
    ];

}

$requests_menu = [];

if ($_USER['user_level'] == 3) {
    $requests_menu[] = [
        'title' => $_LANG['requests']['all']['title'],
        'url' => HOME_URL."requests/all",
        'select' => false
    ];
}
if ($_USER['user_level'] > 1) {
    $requests_menu[] = [
        'title' => $_LANG['requests']['division']['title'],
        'url' => HOME_URL . "requests/division",
        'select' => false
    ];
    $requests_menu[] = [
        'title' => $_LANG['requests']['my']['title'],
        'url' => HOME_URL . "requests/my",
        'select' => true
    ];
}

View::render("page", [
    'title' => $_LANG['requests']['my']['title'] . " - " . $_CONFIG['system']['site_name'],
    'content' => View::render("menu", [
        'title' => $_LANG['requests']['my']['title'],
        'content' => View::render("default/requests/my", [
            'new_url' => HOME_URL."requests/new",
            'menu' => $requests_menu,
            'requests' => $requests_page,
            'pages' => $pages
        ])
    ])
])->display();