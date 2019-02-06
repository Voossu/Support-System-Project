<?php

/* ----------------------- mail work ----------------------- */

function send_mail($to = "voossu@gmail.com", $subject = "Recruitment", $message = "Hi. How are you?", $from = "lol@voossu.com.ua") {
    $headers   = [];

    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-type: text/plain; charset=utf8";
    $headers[] = "From: White House <{$from}>";
    $headers[] = "Reply-To: none";
    $headers[] = "Subject: {$subject}";
    $headers[] = "X-Mailer: PHP/".phpversion();

    return mail($to, $subject, $message, implode("\r\n", $headers));
}

/* ----------------------- url work ----------------------- */

/**
 * @param $url string
 */
function move_to($url) {
    header("Location: {$url}");
    die();
}


/* --------------------- json dir work --------------------- */

/**
 * @param $dir_path String
 * @return array
 */
function json_dir_values($dir_path) {
    $files_in_config_dir = scandir($dir_path);
    $values = [];
    foreach ($files_in_config_dir as $file) {
        if (substr($file, -5) === ".json") {
            $values[substr($file, 0, strlen($file) - 5)] = json_decode(file_get_contents($dir_path . $file), true);
        }
    }
    return $values;
}

/**
 * @param $dir_path String
 * @param $temp_path String
 * @return array
 * @throws ErrorException
 */
function load_json_dir_values_with_cash($dir_path, $temp_path) {
    $values = [];
    if (!is_dir($dir_path)) {
        throw new ErrorException("The path \$dir_path does not point to a real directory.");
    }
    /*
    if (is_readable($temp_path)) {
        $values = unserialize(file_get_contents($temp_path));
    } else {
        $values = json_dir_values($dir_path);
        file_put_contents($temp_path, serialize($values));
    }*/
    $values = json_dir_values($dir_path);
    return $values;
}

/* ------------------------- str work ------------------------- */

/**
 * @param $str string
 * @param $inserts array
 * @return string
 */
function str_insert($str, $inserts) {
    foreach ($inserts as $key => $insert) {
        $str = str_replace($str, "%{$key}%", $insert);
    }
    return $str;
}

/**
 * @param $length integer
 * @return string
 */
function str_rand($length) {
    return substr(bin2hex(random_bytes($length / 2 + 1)), 0, $length);
}
