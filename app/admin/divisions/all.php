<?php

if (!empty($_ROUTING['params'])) {
    move_to(HOME_URL."invites/all");
}

use lib\model\Divisions;

$divisions = Divisions::get_all_divisions();

$divisions_page = [];

foreach ($divisions as $division) {
    $divisions_page[] = [
        'division_id' => $division['division_id'],
        'division_name' => $division['division_name'] ?? "-",
        'division_description' => $division['division_description'] ?? "-",
        'division_href' => HOME_URL."divisions/{$division['division_id']}/edit"
    ];
}

View::render("page", [
    'title' => $_LANG['divisions']['title'] . " - " . $_CONFIG['system']['site_name'],
    'content' => View::render("menu", [
        'title' => $_LANG['divisions']['title'],
        'content' => View::render("admin/divisions/all", [
            'new_href' => HOME_URL."divisions/new",
            'divisions' => $divisions_page
        ])
    ])
])->display();