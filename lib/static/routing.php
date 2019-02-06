<?php

$_ROUTING['section'] = "default";
$_ROUTING['lang']    = $_USER['user_lang'] ?? $_CONFIG['system']['default_lang'];
$_ROUTING['module']  = null;
$_ROUTING['action']  = null;
$_ROUTING['params']  = [];

{
    global $_CONFIG, $_ROUTING;

    $url       = preg_replace('/\/+/', '/', trim(strtolower(urldecode($_SERVER['REQUEST_URI']))));
    $url_start = strlen(DIR_ADDRESS);
    $url_end   = ($url_end = strpos($url, '?')) ? $url_end - 1 : strlen($url);
    $url       = preg_replace('/\/+$/', '', substr($url, $url_start, $url_end));
    $url       = strlen($url) ? preg_split('/\/+/', $url) : [];


    if (current($url) === $_CONFIG['system']['admin_path']) {
        $_ROUTING['section'] = "admin";
        array_shift($url);
    }

    if (is_lang(current($url))) {
        $_ROUTING['lang'] = current($url);
        array_shift($url);
    }

    if (!empty($url) && file_exists(APP_DIR."{$_ROUTING['section']}/".current($url))) {
        $_ROUTING['module']  = current($url);
        array_shift($url);
    } else {
        $_ROUTING['module']  = "index";
    }

    $_ROUTING['action']  = null;
    if (file_exists(APP_DIR."{$_ROUTING['section']}/{$_ROUTING['module']}/".current($url).".php")) {
        $_ROUTING['action']  = current($url);
        array_shift($url);
    } else {
        $_ROUTING['action']  = "index";
    }

    $_ROUTING['params'] = $url;
}