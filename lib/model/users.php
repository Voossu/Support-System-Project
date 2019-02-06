<?php namespace lib\model;

abstract class Users {

    /**
     * @param $email string
     * @param $pass string
     * @return null|string
     */
    static function new_user($email, $pass) {
        global $_CONFIG, $_DATABASE;
        return preg_match("/{$_CONFIG['regexp']['email']}/", $email) && $_DATABASE->prepare("
          INSERT INTO users (user_email, user_pass)
          VALUES (:user_email, :user_pass);
        ")->execute([
            'user_email' => $email,
            'user_pass' => $pass
        ]) ? $_DATABASE->lastInsertId() : null;
    }

    /**
     * @param $id integer
     * @param $pass string
     * @param $first_name string
     * @param $second_name string
     * @param $last_name string
     * @param $division integer
     * @param $post string
     * @param $phone string
     * @param $locked integer
     * @param $level integer
     * @return bool
     */
    static function update_user($id, $pass, $first_name, $second_name, $last_name, $division, $post, $phone, $locked, $level) {
        global $_DATABASE;
        return $_DATABASE->prepare("
          UPDATE users
          SET user_pass = :user_pass,
              user_firstname = :user_firstname,
              user_secondname = :user_secondname,
              user_lastname = :user_lastname,
              user_division = :user_division,
              user_post = :user_post,
              user_phone = :user_phone,
              user_locked = :user_locked,
              user_level = :user_level
          WHERE user_id = :user_id;
        ")->execute([
            'user_id' => $id,
            'user_pass' => $pass,
            'user_firstname' => $first_name,
            'user_secondname' => $second_name,
            'user_lastname' => $last_name,
            'user_division' => $division,
            'user_post' => $post,
            'user_phone' => $phone,
            'user_locked' => $locked,
            'user_level' => $level
        ]);
    }

    /**
     * @param $id integer
     * @return mixed|null
     */
    static function get_user($id) {
        global $_DATABASE;
        $stmt = $_DATABASE->prepare("
          SELECT *
          FROM users
          WHERE user_id = :user_id;
        ");
        $stmt->execute([
            'user_id' => $id
        ]);
        return $stmt->fetch();
    }

    /**
     * @param $email string
     * @return array|mixed
     *
     */
    static function get_user_by_email($email) {
        global $_CONFIG, $_DATABASE;
        if (!preg_match("/{$_CONFIG['regexp']['email']}/", $email)) {
            return [];
        }
        $stmt = $_DATABASE->prepare("
          SELECT *
          FROM users
          WHERE user_email = :user_email;
        ");
        $stmt->execute([
            'user_email' => $email
        ]);
        return $stmt->fetch();
    }

    /**
     * @param $count integer
     * @return integer
     */
    static function get_page_count($count) {
        global $_DATABASE;
        if ($count === 0) {
            return 1;
        }
        $stmt = $_DATABASE->prepare("
          SELECT count(1) as users_count
          FROM users;
        ");
        $stmt->execute();
        return ceil($stmt->fetch()['users_count'] / $count);
    }

    /**
     * @param $count integer
     * @param $page integer
     * @return array(mixed)|null
     */
    static function get_users($count, $page) {
        global $_DATABASE;
        $offset = ($page - 1) * $count;
        $stmt = $_DATABASE->prepare("
          SELECT user_id, user_email, user_firstname, user_secondname, user_lastname, user_division, user_post, user_phone, user_level, user_locked
          FROM users
          LIMIT {$offset}, {$count};
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @param $count integer
     * @param $page integer
     * @param $query string
     * @return array
     */
    static function get_users_search($count, $page, $query) {
        global $_DATABASE;
        $offset = ($page - 1) * $count;
        $stmt = $_DATABASE->prepare("
          SELECT user_id, user_email, user_firstname, user_secondname, user_lastname, user_division, user_post, user_phone, user_level, user_locked
          FROM users
          WHERE user_email LIKE :search
             or user_firstname LIKE :search
             or user_secondname LIKE :search
             or user_lastname LIKE :search
             or user_post LIKE :search
             or (SELECT division_name FROM divisions WHERE division_id = user_division) LIKE :search
          LIMIT {$offset}, {$count};
        ");
        $stmt->execute([
            'search' => '%'.$query.'%'
        ]);
        return $stmt->fetchAll();
    }

    /**
     * @param $count integer
     * @param $query string
     * @return integer
     */
    static function get_page_search_count($count, $query) {
        global $_DATABASE;
        if ($count === 0) {
            return 1;
        }
        $stmt = $_DATABASE->prepare("
          SELECT count(1) as users_count
          FROM users
          WHERE user_email LIKE :search
             or user_firstname LIKE :search
             or user_secondname LIKE :search
             or user_lastname LIKE :search
             or user_post LIKE :search
             or (SELECT division_name FROM divisions WHERE division_id = user_division) LIKE :search;
        ");
        $stmt->execute([
            'search' => '%'.$query.'%'
        ]);
        return ceil($stmt->fetch()['users_count'] / $count);
    }

}