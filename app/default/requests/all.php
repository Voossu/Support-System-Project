<?php

if (empty($_USER)) {
    move_to(DEFAULT_URL."user/login");
}

if (count($_ROUTING['params']) > 2) {
    move_to(HOME_URL."requests/all?division={$_GET['division']}&display={$_GET['display']}");
}

$count = $_ROUTING['params'][0] ?? 15;
$page = $_ROUTING['params'][1] ?? 1;

if (!is_numeric($count) || !is_numeric($page)) {
    move_to(HOME_URL."requests/all?division={$_GET['division']}&display={$_GET['display']}");
}

use lib\model\Requests;
use lib\model\Divisions;

$division = null;

if (!empty($_GET['division'])) {
    $division = Divisions::get_division($_GET['division']);
    if (empty($division)) {
        move_to(HOME_URL."requests/all?division=&display={$_GET['display']}");
    }
} else {
    unset($division);
}

$status_code = [
    'expects'  => 0,
    'consider' => 1,
    'executed' => 2,
    'rejected' => 3,
    'cancel' => 4
];

$status = null;

if (isset($_GET['display']) && !empty($_GET['display'])) {
    if (array_key_exists($_GET['display'], $status_code)) {
        $status = $status_code[$_GET['display']];
    } else {
        move_to(HOME_URL."requests/all?division={$_GET['division']}&display=");
    }
} else {
    unset($status);
}

$requests_page = isset($division)
    ? (isset($status)
    ? Requests::get_requests_by_division_status($division['division_id'], $status, $count, $page)
    : Requests::get_requests_by_division($division['division_id'], $count, $page))
    : (isset($status)
    ? Requests::get_requests_by_status($status, $count, $page)
    : Requests::get_requests($count, $page));

if ($page !== 1 && empty($requests_page)) {
    move_to(HOME_URL."requests/division".empty($status)?"":"/{}");
}

foreach ($requests_page as $key => $request) {
    $requests_page[$key]['href'] = HOME_URL."requests/{$request['request_id']}";
}

$page_count = isset($division)
    ? (isset($status)
    ? Requests::get_division_status_page_count($division['division_id'], $status, $count)
    : Requests::get_division_page_count($division['division_id'], $count))
    : (isset($status)
    ? Requests::get_status_page_count($status, $count)
    : Requests::get_page_count($count));

$pages = [];

if ($page_count > 1) {

    $pages['left'] = $page > 1 ? [
        'href' => HOME_URL."requests/all/{$count}/".($page - 1)."?division={$_GET['division']}&display={$_GET['display']}",
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
            'href'   => HOME_URL."requests/all/{$count}/{$i}?division={$_GET['division']}&display={$_GET['display']}",
            'active' => $i == $page
        ];
    }

    $pages['right'] = $page < $page_count ? [
        'href' => HOME_URL."requests/all/{$count}/".($page + 1)."?division={$_GET['division']}&display={$_GET['display']}",
        'disabled' => false
    ] : [
        'href' => "",
        'disabled' => true
    ];

}

$requests_menu = [
    [
        'title' => $_LANG['requests']['all']['title'],
        'url' => HOME_URL."requests/all",
        'select' => true
    ],
    [
        'title' => $_LANG['requests']['division']['title'],
        'url' => HOME_URL."requests/division",
        'select' => false
    ],
    [
        'title' => $_LANG['requests']['my']['title'],
        'url' => HOME_URL."requests/my",
        'select' => false
    ]
];


$activities[] = [
    'title' => $_LANG['requests']['all_to_division'],
    'value' => "",
    'select' => !isset($status)
];
foreach ($status_code as $key => $code) {
    $activities[] = [
        'title' => $_LANG['requests']['statuses'][$code],
        'value' => $key,
        'select' => isset($status) && $status == $code
    ];
}


View::render("page", [
    'title' => $_LANG['requests']['division']['title'] . " - " . $_CONFIG['system']['site_name'],
    'content' => View::render("menu", [
        'title' => $_LANG['requests']['division']['title'],
        'content' => View::render("default/requests/all", [
            'menu' => $requests_menu,
            'requests' => $requests_page,
            'pages' => $pages,
            'activity_form' => [
                'handler' => HOME_URL."requests/all",
                'method' => "get",
                'fields' => [
                    'division' => [
                        'name' => 'division',
                        'values' => Divisions::get_all_divisions(),
                        'value' => $division['division_id'] ?? 0
                    ],
                    'activities' => [
                        'name' => 'display',
                        'values' => $activities
                    ]
                ]
            ]
        ])
    ])
])->display();