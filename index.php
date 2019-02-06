<?php

define('DIR_ADDRESS', str_replace('\\', '/', substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']), strlen(__DIR__))).'/');

define('ROOT_URL', "//{$_SERVER['SERVER_NAME']}".DIR_ADDRESS);
define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT'].DIR_ADDRESS);

const RES_URL   = ROOT_URL.'res/';

const APP_DIR  = ROOT_DIR.'app/';
const LIB_DIR  = ROOT_DIR.'lib/';
const RES_DIR  = ROOT_DIR.'res/';
const TEMP_DIR = ROOT_DIR.'temp/';
const VIEW_DIR = ROOT_DIR.'view/';

const CONFIG_DIR = RES_DIR.'config/';
const LANG_DIR   = RES_DIR.'lang/';

include LIB_DIR.'init.php';


if (file_exists(APP_DIR . "{$_ROUTING['section']}/{$_ROUTING['module']}/{$_ROUTING['action']}.php")) {
    if ($_ROUTING['section'] !== "admin" || ($_ROUTING['section'] === "admin" && $_USER['user_level'] == 3)) {
        include APP_DIR . "{$_ROUTING['section']}/{$_ROUTING['module']}/{$_ROUTING['action']}.php";
    } else {
        echo 404;
    }
} else {
    echo 404;
}

