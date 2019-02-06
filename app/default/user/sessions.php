<?php

if (empty($_USER)) {
    move_to(DEFAULT_URL."user/login");
}

if (count($_ROUTING['params']) > 2) {
    move_to(HOME_URL."user/sessions");
}

$sessions_menu = [
    [
        'title'  => $_LANG['users']['profile']['title'],
        'url'    => HOME_URL."user/profile",
    ],
    [
        'title' => $_LANG['users']['details']['title'],
        'url'   => HOME_URL."user/details"
    ],
    [
        'title' => $_LANG['users']['sessions']['title'],
        'url'   => HOME_URL."user/sessions",
        'select' => true
    ]
];

$count = $_ROUTING['params'][0] ?? 15;
$page = $_ROUTING['params'][1] ?? 1;

if (!is_numeric($count) || !is_numeric($page)) {
    move_to(HOME_URL."user/sessions");
}

use lib\model\Sessions;

$sessions_page = Sessions::get_sessions($_USER['user_id'], $count, $page);

if (empty($sessions_page)) {
    move_to(HOME_URL."user/sessions");
}

$page_count = Sessions::get_page_count($_USER['user_id'], $count);

$pages = [];

if ($page_count > 1) {

    $pages['left'] = $page > 1 ? [
        'href' => HOME_URL."user/sessions/{$count}/".($page - 1),
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
            'href'   => HOME_URL."user/sessions/{$count}/{$i}",
            'active' => $i == $page
        ];
    }

    $pages['right'] = $page < $page_count ? [
        'href' => HOME_URL."user/sessions/{$count}/".($page + 1),
        'disabled' => false
    ] : [
        'href' => "",
        'disabled' => true
    ];

}

View::render("page", [
    'title' => $_LANG['users']['sessions']['title'] . " - " . $_CONFIG['system']['site_name'],
    'content' => View::render("menu", [
        'title' => $_LANG['users']['sessions']['title'],
        'content' => View::render("default/user/sessions", [
            'menu' => $sessions_menu,
            'sessions' => $sessions_page,
            'pages' => $pages
        ])
    ])
])->display();