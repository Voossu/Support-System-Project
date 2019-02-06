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
    View::render("page", [
        'title' => $_LANG['users']['users']['title'] . " - " . $_CONFIG['system']['site_name'],
        'content' => View::render("menu", [
            'title' => $_LANG['users']['users']['title'],
            'content' => View::render("default/requests/empty_profile")
        ])
    ])->display();
    die();
}

if (empty($_ROUTING['params'])) {
    switch ($_USER['user_level']) {
        case 1:
            move_to(HOME_URL."requests/my");
            break;
        case 2:
            move_to(HOME_URL."requests/division");
            break;
        default:
            move_to(HOME_URL."requests/all");
    }
}

use lib\model\Users;
use lib\model\Requests;
use lib\model\Divisions;

if (!is_numeric($_ROUTING['params'][0])) {
    move_to(HOME_URL."requests");
}

$request = Requests::get_request($_ROUTING['params'][0]);
$request_user = null;
$request_division = null;
$request_meta = null;
$available_activity = [];

if ($request['request_user'] !== $_USER['user_id'] && $_USER['user_level'] < 2) {
    move_to(HOME_URL."requests");
}

if (!empty($request) && !empty($_ROUTING['params'][1])) {
    if ($_ROUTING['params'][1] === "handler" && $request['request_status'] < 2 && ($_USER['user_level'] == 3
            || ($_USER['user_level'] > 1 && $_USER['user_division'] === $request['request_division']))) {
        if ($request['request_user'] == $_USER['user_id'] && $_POST['activity'] == "cancel") {
            Requests::set_request_status($request['request_id'], 4, $_USER['user_id']);
        }
        if ($request['request_status'] == null && $_POST['activity'] == "perform") {
            Requests::set_request_status($request['request_id'], 1, $_USER['user_id']);
        } elseif ($_POST['activity'] == "done") {
            Requests::set_request_status($request['request_id'], 2, $_USER['user_id']);
        } elseif ($_POST['activity'] == "reject") {
            Requests::set_request_status($request['request_id'], 3, $_USER['user_id']);
        }

    }
    move_to(HOME_URL."requests/{$_ROUTING['params'][0]}");
}


if (!empty($request)) {
    $request_user = Users::get_user($request['request_user']);
    $request_user['user_fullname'] = (!empty($user['user_firstname']) ? $user['user_firstname'] . " " : "")
        . (!empty($user['user_secondname']) ? $user['user_secondname'] . " " : "")
        . (!empty($user['user_lastname']) ? $user['user_lastname'] : "");
    $request_division = empty($request['request_division'])
        ? null
        : Divisions::get_division($request['request_division']);
    $request_meta = Requests::get_requests_statuses($request['request_id']);
    foreach ($request_meta as $key => $meta) {
        $status_set_user = Users::get_user($meta['status_set_user']);
        $request_meta[$key]['status_set_user'] = [
            'title' => "&lt;{$status_set_user['user_email']}&gt;",
            'href' => ($_USER['user_level'] === 3 ? ADMIN_URL : DEFAULT_URL)."users/{$status_set_user['user_id']}"
        ];
    }
    if ($request['request_status'] < 2 && ($_USER['user_level'] == 3 || ($_USER['user_level'] > 1 && $_USER['user_division'] === $request['request_division']))) {
        if ($request['request_user'] === $_USER['user_id']) {
            $available_activity[] = [
                'value' => "cancel",
                'title' => $_LANG['requests']['statuses'][4]
            ];
        }
        if ($request['request_status'] == null) {
            $available_activity[] = [
                'value' => "perform",
                'title' => $_LANG['requests']['statuses'][1]
            ];
        }
        $available_activity[] = [
            'value' => "done",
            'title' => $_LANG['requests']['statuses'][2]
        ];
        $available_activity[] = [
            'value' => "reject",
            'title' => $_LANG['requests']['statuses'][3]
        ];
    }
}

View::render("page", [
    'title' => $_LANG['requests']['request']['title'] . " - " . $_CONFIG['system']['site_name'],
    'content' => View::render("menu", [
        'title' => $_LANG['requests']['request']['title'],
        'content' => View::render("default/requests/request", [
            'request' => $request,
            'user' => $request_user,
            'division' => $request_division,
            'statuses' => $request_meta,
            'status_form' => [
                'handler' => HOME_URL."requests/{$_ROUTING['params'][0]}/handler",
                'method' => 'post',
                'fields' => [
                    'activity' => [
                        'name' => 'activity',
                        'activates' => $available_activity,
                    ]
                ]
            ]
        ])
    ])
])->display();
