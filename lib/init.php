<?php

if (!file_exists(TEMP_DIR)) {
    if (!mkdir(TEMP_DIR)) {
        throw new ErrorException("Temp folder not exist!");
    }
}

session_start();

/* ------------------ load system libs ------------------ */

include LIB_DIR.'static/functions.php';

include LIB_DIR.'static/config.php';
include LIB_DIR.'static/lang.php';

include LIB_DIR.'static/view.php';
include LIB_DIR.'static/routing.php';

set_lang($_ROUTING['lang']);

define('DEFAULT_URL', ROOT_URL."{$_ROUTING['lang']}/");
define('ADMIN_URL',   ROOT_URL."admin/{$_ROUTING['lang']}/");
define('HOME_URL',    ROOT_URL.($_ROUTING['section'] === "default" ? "" : "admin/")."{$_ROUTING['lang']}/");

/* ------------------ database connection ------------------ */

$_DATABASE = new PDO(

    "mysql:host={$_CONFIG['database']['host']};dbname={$_CONFIG['database']['base']}",
    $_CONFIG['database']['user'],
    $_CONFIG['database']['pass'], [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_SILENT,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC

]);

/* --------------------- autoload_model --------------------- */

spl_autoload_register('autoload_app_class');

function autoload_app_class($class_name) {
    $class_params = preg_split('/[\\\\]+/', strtolower($class_name));
    if (count($class_params) > 2 && $class_params[0] === "lib" && $class_params[1] === "model") {
        array_shift($class_params);
        $address = LIB_DIR.implode('/', $class_params).".php";
        if (is_readable($address)) {
            include_once $address;
        }
    }
}

/* ----------------- load other system libs ----------------- */
include LIB_DIR.'static/user.php';
include LIB_DIR.'static/menu.php';
