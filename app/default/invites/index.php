<?php

if (empty($_USER)) {
    move_to(DEFAULT_URL."user/login");
} elseif($_USER['user_level'] < 2) {
    move_to(HOME_URL);
}

if (count($_ROUTING['params']) !== 2 || !is_numeric($_ROUTING['params'][0])) {
    move_to(HOME_URL."invites/all");
}

use lib\model\Invites;
$invite = Invites::get_invite($_ROUTING['params'][0]);

if (empty($invite)) {
    move_to(HOME_URL."invites/all");
}

switch($_ROUTING['params'][1]) {
    case 'disable':
        Invites::disabled_invite($_ROUTING['params'][0]);
        break;
    case 'enable':
        Invites::enable_invite($_ROUTING['params'][0]);
        break;
    default:
        break;
}

move_to($_GET['goto'] ?? HOME_URL."invites/all");