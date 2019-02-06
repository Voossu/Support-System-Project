<?php

if (empty($_USER)) {
    die("404");
}

use lib\model\Sessions;

Sessions::end_current_session();
$_USER = null;
unset($_SESSION);

move_to(HOME_URL);