<?php

if (!is_numeric($_ROUTING['params'][0])) {
    move_to(HOME_URL."users/all");
}

use lib\model\Users;
use lib\model\Invites;
use lib\model\Sessions;
use lib\model\Divisions;

$user = Users::get_user($_ROUTING['params'][0]);

switch ($_ROUTING['params'][1]) {
    case 'profile':
        if (count($_ROUTING['params']) > 3) {
            move_to(HOME_URL."users/{$user['user_id']}/profile");
        }
        $params_exist = count($_ROUTING['params']) === 3;
        $is_handler = $params_exist && $_ROUTING['params'][2] === "handler";
        if ($params_exist && !$is_handler) {
            move_to(HOME_URL."users/{$user['user_id']}/profile");
        }
        $profile_menu = [
            [
                'title'  => $_LANG['users']['profile']['title'],
                'url'    => HOME_URL."users/{$user['user_id']}/profile",
                'select' => true
            ],
            [
                'title' => $_LANG['users']['details']['title'],
                'url'   => HOME_URL."users/{$user['user_id']}/details"
            ],
            [
                'title' => $_LANG['users']['sessions']['title'],
                'url'   => HOME_URL."users/{$user['user_id']}/sessions"
            ]
        ];
        if ($is_handler) {
            if ($user['user_id'] === $_USER['user_id']) {
                Users::update_user($user['user_id'], $user['user_pass'],
                    $_POST['firstname'], $_POST['secondname'], $_POST['lastname'],
                    empty($_POST['division']) ? null : $_POST['division'], $_POST['post'],
                    $_POST['phone'], $user['user_locked'], $user['user_level']);
            } else {
                Users::update_user($user['user_id'], $user['user_pass'],
                    $_POST['firstname'], $_POST['secondname'], $_POST['lastname'],
                    empty($_POST['division']) ? null : $_POST['division'], $_POST['post'],
                    $_POST['phone'], $_POST['locked'], $_POST['level']);
            }
            move_to(HOME_URL."users/{$user['user_id']}/profile");
        } else {
            $division_list = Divisions::get_all_divisions();
            $level_list = $_LANG['users']['levels'];
            View::render("page", [
                'title' => $_LANG['users']['profile']['title'] . " - " . $_CONFIG['system']['site_name'],
                'content' => View::render("menu", [
                    'title' => $_LANG['users']['profile']['title'],
                    'content' => View::render("admin/users/profile", [
                        'menu' => $profile_menu,
                        'user' => $user,
                        'profile_errors' => $_SESSION['profile']['errors'] ?? [],
                        'profile_action' => HOME_URL . "users/{$user['user_id']}/profile/handler",
                        'profile_method' => "post",
                        'fields' => [
                            'id' => [
                                'name' => "id"
                            ],
                            'email' => [
                                'name' => "email",
                                'length' => 64
                            ],
                            'firstname' => [
                                'name' => "firstname",
                                'length' => 16
                            ],
                            'secondname' => [
                                'name' => "secondname",
                                'length' => 16
                            ],
                            'lastname' => [
                                'name' => "lastname",
                                'length' => 16
                            ],
                            'division' => [
                                'name' => "division",
                                'empty' => null,
                                'list' => $division_list
                            ],
                            'post' => [
                                'name' => "post",
                                'length' => 16
                            ],
                            'phone' => [
                                'name' => "phone",
                                'length' => 16
                            ],
                            'level' => [
                                'name' => "level",
                                'list' => $level_list
                            ],
                            'locked' => [
                                'name' => "locked"
                            ]
                        ]
                    ])
                ])
            ])->display();
        }
        break;
    case 'details':
        if (count($_ROUTING['params']) > 2) {
            move_to(HOME_URL."users/{$user['user_id']}/details");
        }
        $details_menu = [
            [
                'title'  => $_LANG['users']['profile']['title'],
                'url'    => HOME_URL."users/{$user['user_id']}/profile"
            ],
            [
                'title' => $_LANG['users']['details']['title'],
                'url'   => HOME_URL."users/{$user['user_id']}/details",
                'select' => true
            ],
            [
                'title' => $_LANG['users']['sessions']['title'],
                'url'   => HOME_URL."users/{$user['user_id']}/sessions"
            ]
        ];
        $invite = Invites::get_user_invite($_USER['user_id']);
        $invite_get_user = Users::get_user($invite['invite_get_user']);
        View::render("page", [
            'title' => $_LANG['users']['details']['title'] . " - " . $_CONFIG['system']['site_name'],
            'content' => View::render("menu", [
                'title' => $_LANG['users']['details']['title'],
                'content' => View::render("admin/users/details", [
                    'menu' => $details_menu,
                    'user' => $user,
                    'invite' => [
                        'get_user' => [
                            'title' => empty($invite_get_user)
                                ? "system"
                                : ( "&lt;{$invite_get_user['user_email']}&gt; "
                                    . (!empty($invite_get_user['user_firstname']) ? $invite_get_user['user_firstname'] ." " : "")
                                    . (!empty($invite_get_user['user_secondname']) ? $invite_get_user['user_secondname'] . " " : "")
                                    . (!empty($invite_get_user['user_lastname']) ? $invite_get_user['user_lastname'] : "") ),
                            'href' => HOME_URL."users/{$invite_get_user['user_id']}/profile"
                        ],
                        'date' => $invite['invite_date']
                    ]
                ])
            ])
        ])->display();
        break;
    case 'sessions':
        if (count($_ROUTING['params']) > 5) {
            move_to(HOME_URL."users/{$user['user_id']}/sessions");
        }
        $count = $_ROUTING['params'][2] ?? 15;
        $page = $_ROUTING['params'][3] ?? 1;
        if (!is_numeric($count) || !is_numeric($page)) {
            move_to(HOME_URL."users/{$user['user_id']}/sessions");
        }
        $sessions_menu = [
            [
                'title'  => $_LANG['users']['profile']['title'],
                'url'    => HOME_URL."users/{$user['user_id']}/profile"
            ],
            [
                'title' => $_LANG['users']['details']['title'],
                'url'   => HOME_URL."users/{$user['user_id']}/details"
            ],
            [
                'title' => $_LANG['users']['sessions']['title'],
                'url'   => HOME_URL."users/{$user['user_id']}/sessions",
                'select' => true
            ]
        ];
        $sessions_page = Sessions::get_sessions($user['user_id'], $count, $page);
        if ($page != 1 && empty($sessions_page)) {
            move_to(HOME_URL."users/{$user['user_id']}/sessions");
        }
        $page_count = Sessions::get_page_count($user['user_id'], $count);
        $pages = [];
        if ($page_count > 1) {
            $pages['left'] = $page > 1 ? [
                'href' => HOME_URL."users/{$user['user_id']}/sessions/{$count}/".($page - 1),
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
                    'href'   => HOME_URL."users/{$user['user_id']}/sessions/{$count}/{$i}",
                    'active' => $i == $page
                ];
            }
            $pages['right'] = $page < $page_count ? [
                'href' => HOME_URL."users/{$user['user_id']}/sessions/{$count}/".($page + 1),
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
                'content' => View::render("admin/users/sessions", [
                    'menu' => $sessions_menu,
                    'sessions' => $sessions_page,
                    'pages' => $pages
                ])
            ])
        ])->display();
        break;
    default:
        move_to(HOME_URL."users/{$user['user_id']}/profile");
        break;
}
