<?php

if (count($_ROUTING['params']) < 2 || !is_numeric($_ROUTING['params'][0])) {
    move_to(HOME_URL."divisions/all");
}

use lib\model\Divisions;

$division = Divisions::get_division($_ROUTING['params'][0]);

switch ($_ROUTING['params'][1]) {
    case 'edit':
        $is_handler = !empty($division) && count($_ROUTING['params']) === 3 && $_ROUTING['params'][2] === "handler";

        if (count($_ROUTING['params']) > 2 && !$is_handler) {
            move_to(HOME_URL."divisions/{$_ROUTING['params'][0]}/edit");
        }

        if ($is_handler) {
            if (empty($_POST['name'])) {
                $_SESSION['edit']['errors'][] = $_LANG['divisions']['title_no_set'];
            }
            if (empty($_SESSION['edit']['errors'])) {
                Divisions::update_division($division['division_id'], $_POST['name'], $_POST['description']);
            } else {
                $_SESSION['edit']['fields'] = $_POST;
            }
            move_to(HOME_URL."divisions/{$_ROUTING['params'][0]}/edit");
        } else {
            View::render("page", [
                'title' => $_LANG['divisions']['edit']['title'] . " - " . $_CONFIG['system']['site_name'],
                'content' => View::render("menu", [
                    'title' => $_LANG['divisions']['edit']['title'],
                    'content' => View::render("admin/divisions/edit", [
                        'edit_errors' => $_SESSION['edit']['errors'],
                        'all_divisions_href' => HOME_URL."divisions/all",
                        'delete_division' => HOME_URL."divisions/{$division['division_id']}/delete",
                        'edit_action' => HOME_URL."divisions/{$division['division_id']}/edit/handler",
                        'edit_method' => "post",
                        'division' => $division,
                        'fields' => [
                            'name' => [
                                'name' => "name",
                                'length' => 32,
                                'value' => $_SESSION['edit']['fields']['name'] ?? $division['division_name']
                            ],
                            'description' => [
                                'name' => "description",
                                'length' => 256,
                                'value' => $_SESSION['edit']['fields']['description'] ?? $division['division_description']
                            ]
                        ]
                    ])
                ])
            ])->display();
            unset($_SESSION['edit']);
        }
        break;
    case 'delete':
        Divisions::delete_division($division['division_id']);
        move_to(HOME_URL."divisions/all");
        break;
    default;
        move_to(HOME_URL."divisions/all");
        break;
}

