<?php

$_LANG = [];

if (!file_exists(LANG_DIR)) {
    throw new ErrorException("Lang folder not exist!");
}

function is_lang($lang_code) {
    return !empty($lang_code) && file_exists(LANG_DIR.$lang_code.'/');
}

function set_lang($lang_code) {
    if (!is_lang($lang_code)) {
        throw new ErrorException("Language with code '{$lang_code}' non supported!");
    }
    global $_LANG;
    $_LANG = load_json_dir_values_with_cash(LANG_DIR."{$lang_code}/", TEMP_DIR."lang-{$lang_code}.dat");
}