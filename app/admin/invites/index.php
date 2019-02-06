<?php

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
    case 'delete':
        Invites::delete_invite($_ROUTING['params'][0]);
        break;
    default:
        break;
}

move_to($_GET['goto'] ?? HOME_URL."invites/all");