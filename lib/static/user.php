<?php

use lib\model\Sessions;
use lib\model\Users;

$_USER = null;

{
    $user_id = Sessions::get_current_session_user();
    if (!empty($user_id)) {
        $user = Users::get_user($user_id);
        if ($user['user_locked'] === 1) {
            Sessions::end_current_session();
        } else {
            $_USER = $user;
        }
    }
}
