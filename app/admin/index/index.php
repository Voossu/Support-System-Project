<?php



View::render("page", [
    'title' => $_LANG['home']['title'] . " - " . $_CONFIG['system']['site_name'],
    'content' => View::render("menu", [
        'title' => $_LANG['home']['title'],
        'content' => ""
    ])
])->display();