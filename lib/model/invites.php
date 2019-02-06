<?php namespace lib\model;

abstract class Invites {

    /**
     * @param $code string
     * @param $get_user integer
     * @return null|integer
     */
    static function new_invite($code, $get_user) {
        global $_DATABASE;
        return $_DATABASE->prepare("
          INSERT INTO invites (invite_code, invite_get_user)
          VALUES (:invite_code, :invite_get_user);
        ")->execute([
            'invite_code' => $code,
            'invite_get_user' => $get_user
        ]) ? $_DATABASE->lastInsertId() : null;
    }

    /**
     * @param $id integer
     * @return mixed
     */
    static function get_invite($id) {
        global $_DATABASE;
        $stmt = $_DATABASE->prepare("
          SELECT *
          FROM invites
          WHERE invite_id = :invite_id;
        ");
        $stmt->execute([
            'invite_id' => $id
        ]);
        return $stmt->fetch();
    }

    /**
     * @param $code integer
     * @return mixed
     */
    static function get_invite_by_code($code) {
        global $_DATABASE;
        $stmt = $_DATABASE->prepare("
          SELECT *
          FROM invites
          WHERE invite_code = :invite_code
            and invite_disabled = 0
            and isnull(invite_reg_user);
        ");
        $stmt->execute([
            'invite_code' => $code
        ]);
        return $stmt->fetch();
    }

    /**
     * @param $id integer
     * @param $user integer
     * @return bool
     */
    static function activate_invite($id, $user) {
        global $_DATABASE;
        return $_DATABASE->prepare("
            UPDATE invites
            SET invite_reg_user = :invite_reg_user
            WHERE invite_id = :invite_id
              and invite_disabled = 0
              and isnull(invite_reg_user);
        ")->execute([
            'invite_id' => $id,
            'invite_reg_user' => $user
        ]);
    }

    /**
     * @param $id integer
     * @return bool
     */
    static function disabled_invite($id) {
        global $_DATABASE;
        return $_DATABASE->prepare("
            UPDATE invites
            SET invite_disabled = 1
            WHERE invite_id = :invite_id
              and isnull(invite_reg_user);
        ")->execute([
            'invite_id' => $id
        ]);
    }

    /**
     * @param $id integer
     * @return bool
     */
    static function enable_invite($id) {
        global $_DATABASE;
        return $_DATABASE->prepare("
            UPDATE invites
            SET invite_disabled = 0
            WHERE invite_id = :invite_id
              and isnull(invite_reg_user);
        ")->execute([
            'invite_id' => $id
        ]);
    }

    /**
     * @param $id integer
     * @return bool
     */
    static function delete_invite($id) {
        global $_DATABASE;
        return $_DATABASE->prepare("
            DELETE FROM invites
            WHERE invite_id = :invite_id;
        ")->execute([
            'invite_id' => $id
        ]);
    }

    /**
     * @param $user_id integer
     * @return mixed
     */
    static function get_user_invite($user_id) {
        global $_DATABASE;
        $stmt = $_DATABASE->prepare("
          SELECT *
          FROM invites
          WHERE invite_reg_user = :invite_reg_user;
        ");
        $stmt->execute([
            'invite_reg_user' => $user_id
        ]);
        return $stmt->fetch();
    }

    /**
     * @param $count integer
     * @param $page integer
     * @return array
     */
    static function get_invites_page($count, $page) {
        global $_DATABASE;
        $offset = ($page - 1) * $count;
        $stmt = $_DATABASE->prepare("
          SELECT *
          FROM invites
          ORDER BY invite_date DESC
          LIMIT {$offset}, {$count};
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @param $count integer
     * @return integer
     */
    static function get_invites_page_count($count) {
        global $_DATABASE;
        $stmt = $_DATABASE->prepare("
          SELECT count(1) as invites_count
          FROM invites;
        ");
        $stmt->execute();
        return ceil($stmt->fetch()['invites_count'] / $count);
    }

    /**
     * @param $user_id integer
     * @param $count integer
     * @param $page integer
     * @return mixed
     */
    static function get_invites_page_by_get_users($user_id, $count, $page) {
        global $_DATABASE;
        $offset = ($page - 1) * $count;
        $stmt = $_DATABASE->prepare("
          SELECT *
          FROM invites
          WHERE invite_get_user = :invite_get_user
          ORDER BY invite_date DESC
          LIMIT {$offset}, {$count};
        ");
        $stmt->execute([
            'invite_get_user' => $user_id
        ]);
        return $stmt->fetchAll();
    }

    /**
     * @param $user_id integer
     * @param $count integer
     * @return integer
     */
    static function get_invites_page_count_by_get_users($user_id, $count) {
        global $_DATABASE;
        $stmt = $_DATABASE->prepare("
          SELECT count(1) as invites_count
          FROM invites
          WHERE invite_get_user = :invite_get_user;
        ");
        $stmt->execute([
            'invite_get_user' => $user_id
        ]);
        return ceil($stmt->fetch()['invites_count'] / $count);
    }

    /**
     * @param $count integer
     * @param $page integer
     * @param $query string
     * @return array
     */
    static function get_invites_search_page($count, $page, $query) {
        global $_DATABASE;
        $offset = ($page - 1) * $count;
        $stmt = $_DATABASE->prepare("
          SELECT *
          FROM invites
          WHERE invite_code LIKE :search
             or IF(ISNULL(invite_get_user), \"system\", (SELECT user_email FROM users WHERE user_id = invite_get_user)) LIKE :search
             or IF(ISNULL(invite_reg_user), '', (SELECT user_email FROM users WHERE user_id = invite_reg_user)) LIKE :search
          ORDER BY invite_date DESC
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
    static function get_invites_search_page_count($count, $query) {
        global $_DATABASE;
        $stmt = $_DATABASE->prepare("
          SELECT count(1) as invites_count
          FROM invites
          WHERE invite_code LIKE :search
             or IF(IsEmpty(invite_get_user), \"system\", (SELECT user_email FROM users WHERE user_id = invite_get_user)) LIKE :search
             or IF(IsEmpty(invite_reg_user), '', (SELECT user_email FROM users WHERE user_id = invite_reg_user)) LIKE :search;
        ");
        $stmt->execute([
            'search' => '%'.$query.'%'
        ]);
        return ceil($stmt->fetch()['invites_count'] / $count);
    }
}