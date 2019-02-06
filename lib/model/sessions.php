<?php namespace lib\model;

abstract class Sessions {

    /* ----------------------------------- database work -----------------------------------  */

    /**
     * @param $user integer
     * @param $key string
     * @return null|integer
     */
    static function new_session($user, $key) {
        global $_CONFIG, $_DATABASE;
        $stmt = $_DATABASE->prepare("
          SELECT *
          FROM sessions
          WHERE session_user = :session_user
            and session_key = :session_key
            and session_disabled = 0
            and TIMESTAMPDIFF(HOUR, session_start, session_end) < :max_length_life
            and TIMESTAMPDIFF(HOUR, session_end, CURRENT_TIMESTAMP) < :max_life;
        ");
        $stmt->execute([
            'session_user' => $user,
            'session_key' => $key,
            'max_length_life' => $_CONFIG['session']['max_length_life'],
            'max_life' => $_CONFIG['session']['max_life']
        ]);
        $session = $stmt->fetch();
        if (!empty($session)) {
            $_DATABASE->prepare("
              UPDATE sessions
              SET session_end = CURRENT_TIMESTAMP
              WHERE session_id = :session_id;
            ")->execute([
                'session_id' => $session['session_id']
            ]);
            return $session['session_id'];
        }
        return $_DATABASE->prepare("
          INSERT INTO sessions(session_user, session_key)
          VALUES (:session_user, :session_key)
        ")->execute([
            'session_user' => $user,
            'session_key' => $key
        ]) ? $_DATABASE->lastInsertId() : null;
    }

    /**
     * @param $id integer
     * @return mixed
     */
    static function get_session($id) {
        global $_CONFIG, $_DATABASE;
        $stmt = $_DATABASE->prepare("
          SELECT *
          FROM sessions
          WHERE session_id = :session_id
            and session_disabled = 0
            and TIMESTAMPDIFF(HOUR, session_start, session_end) < :max_length_life
            and TIMESTAMPDIFF(HOUR, session_end, CURRENT_TIMESTAMP) < :max_life;
        ");
        $stmt->execute([
            'session_id' => $id,
            'max_length_life' => $_CONFIG['session']['max_length_life'],
            'max_life' => $_CONFIG['session']['max_life']
        ]);
        $session = $stmt->fetch();
        if (!empty($session)) {
            $_DATABASE->prepare("
              UPDATE sessions
              SET session_end = CURRENT_TIMESTAMP
              WHERE session_id = :session_id;
            ")->execute([
                'session_id' => $session['session_id']
            ]);
        }
        return $session;
    }

    /**
     * @param $id integer
     * @return bool
     */
    static function disabled_session($id) {
        global $_DATABASE;
        return $_DATABASE->prepare("
          UPDATE sessions
          SET session_disabled = TRUE
          WHERE session_id = :session_id;
        ")->execute([
            'session_id' => $id
        ]);
    }

    /**
     * @param $user integer
     * @param $count integer
     * @return integer
     */
    static function get_page_count($user, $count) {
        global $_DATABASE;
        if ($count === 0) {
            return 1;
        }
        $stmt = $_DATABASE->prepare("
          SELECT count(1) as sessions_count
          FROM sessions
          WHERE session_user = :session_user;
        ");
        $stmt->execute([
            'session_user' => $user
        ]);
        return ceil($stmt->fetch()['sessions_count'] / $count);
    }

    /**
     * @param $user integer
     * @param $count integer
     * @param $page integer
     * @return array
     */
    static function get_sessions($user, $count, $page) {
        global $_CONFIG, $_DATABASE;
        $offset = ($page - 1) * $count;
        $stmt = $_DATABASE->prepare("
          SELECT session_id, session_start, session_end, session_disabled,
            (NOT session_disabled) AND (TIMESTAMPDIFF(HOUR, session_start, session_end) >= :max_length_life OR TIMESTAMPDIFF(HOUR, session_end, CURRENT_TIMESTAMP) >= :max_life) as session_timeout
          FROM sessions
          WHERE session_user = :session_user
          ORDER BY session_id DESC
          LIMIT {$offset}, {$count};
        ");
        $stmt->execute([
            'session_user' => $user,
            'max_length_life' => $_CONFIG['session']['max_length_life'],
            'max_life' => $_CONFIG['session']['max_life']
        ]);
        return $stmt->fetchAll();
    }

    /* ----------------------------------- work with session logic -----------------------------------  */

    /**
     * @param $user integer
     * @return bool
     */
    static function start_session_for_user($user) {
        if (empty($_SESSION['session']) && !empty($user)) {
            $_SESSION['session'] = Sessions::new_session($user, $_COOKIE['PHPSESSID']);
            return true;
        }
        return false;
    }

    /**
     * @return integer|null
     */
    static function get_current_session_user() {
        if (!empty($_SESSION['session'])) {
            $session = Sessions::get_session($_SESSION['session']);
            if (!empty($session) && $session['session_key'] === $_COOKIE['PHPSESSID']) {
                return $session['session_user'];
            }
            unset($_SESSION['session']);
        }
        return null;
    }

    /**
     *
     */
    static function end_current_session() {
        Sessions::disabled_session($_SESSION['session']);
        unset($_SESSION['session']);
    }

}