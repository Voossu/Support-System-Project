<?php

$_CONFIG = [];

if (!file_exists(CONFIG_DIR)) {
    throw new ErrorException("Configuration folder not exist!");
}

$_CONFIG = load_json_dir_values_with_cash(CONFIG_DIR, TEMP_DIR."config.dat");