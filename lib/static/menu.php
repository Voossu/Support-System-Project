<?php

if (empty($_ROUTING)) {
    throw new ErrorException("Routing params not found!");
}

$_MENU = $_ROUTING['section'] === 'default' ? (
    empty($_USER) ? [
        [
            'title'  => $_LANG['users']['login']['title'],
            'url'    => DEFAULT_URL.'user/login',
            'select' => $_ROUTING['module'] === 'user' && $_ROUTING['action'] === 'login'
        ],
        [
            'title'  => $_LANG['users']['register']['title'],
            'url'    => DEFAULT_URL.'user/register',
            'select' => $_ROUTING['module'] === 'user' && $_ROUTING['action'] === 'register'
        ]
    ] : ($_USER['user_level'] == 1 ? [
        [
            'title'  => $_LANG['home']['title'],
            'url'    => DEFAULT_URL.'home/index',
            'select' => $_ROUTING['module'] === 'request' && $_ROUTING['action'] === 'my'
        ],
        [
            'title'  => $_LANG['users']['profile']['title'],
            'url'    => DEFAULT_URL.'user/profile/edit',
            'select' => $_ROUTING['module'] === 'user' && (
                    $_ROUTING['action'] === 'profile' ||
                    $_ROUTING['action'] === 'details' ||
                    $_ROUTING['action'] === 'sessions'
                )
        ],
        [
            'title'  => $_LANG['users']['logout']['title'],
            'url'    => DEFAULT_URL.'user/logout',
            'select' => $_ROUTING['module'] === 'user' && $_ROUTING['action'] === 'logout'
        ]
    ] : ($_USER['user_level'] == 2 ? [
        [
            'title'  => $_LANG['home']['title'],
            'url'    => DEFAULT_URL.'home/index',
            'select' => $_ROUTING['module'] === 'request' && $_ROUTING['action'] === 'division'
        ],
        [
            'title'  => $_LANG['users']['users']['title'],
            'url'    => DEFAULT_URL.'users/all',
            'select' => $_ROUTING['module'] === 'users' && $_ROUTING['action'] === 'all'
        ],
        [
            'title'  => $_LANG['invites']['title'],
            'url'    => DEFAULT_URL.'invites/all',
            'select' => $_ROUTING['module'] === 'invites' && $_ROUTING['action'] === 'all'
        ],
        [
            'title'  => $_LANG['users']['profile']['title'],
            'url'    => DEFAULT_URL.'user/profile/edit',
            'select' => $_ROUTING['module'] === 'user' && (
                    $_ROUTING['action'] === 'profile' ||
                    $_ROUTING['action'] === 'details' ||
                    $_ROUTING['action'] === 'sessions'
                )
        ],
        [
            'title'  => $_LANG['users']['logout']['title'],
            'url'    => DEFAULT_URL.'user/logout',
            'select' => $_ROUTING['module'] === 'user' && $_ROUTING['action'] === 'logout'
        ]
    ] : [
        [
            'title'  => $_LANG['home']['title'],
            'url'    => DEFAULT_URL.'home/index',
            'select' => $_ROUTING['module'] === 'request' && $_ROUTING['action'] === 'all'
        ],
        [
            'title'  => $_LANG['users']['users']['title'],
            'url'    => DEFAULT_URL.'users/all',
            'select' => $_ROUTING['module'] === 'users' && $_ROUTING['action'] === 'all'
        ],
        [
            'title'  => $_LANG['invites']['title'],
            'url'    => DEFAULT_URL.'invites/all',
            'select' => $_ROUTING['module'] === 'invites' && $_ROUTING['action'] === 'all'
        ],
        [
            'title'  => $_LANG['users']['profile']['title'],
            'url'    => DEFAULT_URL.'user/profile/edit',
            'select' => $_ROUTING['module'] === 'user' && (
                    $_ROUTING['action'] === 'profile' ||
                    $_ROUTING['action'] === 'details' ||
                    $_ROUTING['action'] === 'sessions'
                )
        ],
        [
            'title'  => $_LANG['admin']['title'],
            'url'    => ADMIN_URL,
            'select' => false
        ],
        [
            'title'  => $_LANG['users']['logout']['title'],
            'url'    => DEFAULT_URL.'user/logout',
            'select' => $_ROUTING['module'] === 'user' && $_ROUTING['action'] === 'logout'
        ]
    ]))) : [
        [
            'title'  => $_LANG['admin']['site'],
            'url'    => DEFAULT_URL,
        ],
        [
            'title'  => $_LANG['home']['title'],
            'url'    => ADMIN_URL.'index/index',
            'select' => $_ROUTING['module'] === 'index' && $_ROUTING['action'] === 'index'
        ],
        [
            'title'  => $_LANG['users']['users']['title'],
            'url'    => ADMIN_URL.'users/all',
            'select' => $_ROUTING['module'] === 'users' && $_ROUTING['action'] === 'all'
        ],
        [
            'title'  => $_LANG['divisions']['title'],
            'url'    => ADMIN_URL.'divisions/all',
            'select' => $_ROUTING['module'] === 'divisions' && $_ROUTING['action'] === 'all'
        ],
        [
            'title'  => $_LANG['invites']['title'],
            'url'    => ADMIN_URL.'invites/all',
            'select' => $_ROUTING['module'] === 'invites' && $_ROUTING['action'] === 'all'
        ]
    ];