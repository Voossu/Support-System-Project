<?php namespace lib\model;

class Requests {

    /**
     * @param $title string
     * @param $description string
     * @param $user integer
     * @param $for_division integer
     * @return int|null
     */
    static function new_request($title, $description, $user, $for_division) {
        global $_DATABASE;
        return $_DATABASE->prepare("
          INSERT INTO requests (request_title, request_description, request_user, request_division)
          VALUES (:request_title, :request_description, :request_user, :request_division);
        ")->execute([
            'request_title' => $title,
            'request_description' => $description,
            'request_user' => $user,
            'request_division' => $for_division
        ]) ? $_DATABASE->lastInsertId() : null;
    }

    /**
     * @param $id integer
     * @return mixed
     */
    static function get_request($id) {
        global $_DATABASE;
        $stmt = $_DATABASE->prepare("
          SELECT *, (
            SELECT request_status FROM request_meta
            WHERE request_meta.request_id = requests.request_id
            ORDER BY meta_id DESC
            LIMIT 1) as request_status,(
            SELECT meta_create FROM request_meta
            WHERE request_meta.request_id = requests.request_id
            ORDER BY meta_id DESC
            LIMIT 1) as request_update
          FROM requests
          WHERE request_id = :request_id;
        ");
        $stmt->execute([
            'request_id' => $id
        ]);
        return $stmt->fetch();
    }

    /**
     * @param $id integer
     * @param $status int
     * @param $user integer
     * @return null|integer
     */
    static function set_request_status($id, $status, $user) {
        global $_DATABASE;
        return $_DATABASE->prepare("
          INSERT INTO request_meta(request_id, request_status, status_set_user)
          VALUES (:request_id, :request_status, :request_user);
        ")->execute([
            'request_id' => $id,
            'request_status' => $status,
            'request_user' => $user
        ]) ? $_DATABASE->lastInsertId() : null;
    }

    /**
     * @param $count
     * @return integer
     */
    static function get_page_count($count) {
        global $_DATABASE;
        if ($count === 0) {
            return 1;
        }
        $stmt = $_DATABASE->prepare("
          SELECT count(1) as requests_count
          FROM requests;
        ");
        $stmt->execute();
        return ceil($stmt->fetch()['requests_count'] / $count);
    }

    /**
     * @param $count integer
     * @param $page integer
     * @return mixed
     */
    static function get_requests($count, $page) {
        global $_DATABASE;
        $offset = ($page - 1) * $count;
        $stmt = $_DATABASE->prepare("
          SELECT *, (
            SELECT request_status FROM request_meta
            WHERE request_meta.request_id = requests.request_id
            ORDER BY meta_id DESC
            LIMIT 1) as request_status,(
            SELECT meta_create FROM request_meta
            WHERE request_meta.request_id = requests.request_id
            ORDER BY meta_id DESC
            LIMIT 1) as request_update
          FROM requests
          ORDER BY request_id DESC
          LIMIT {$offset}, {$count};
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @param $count integer
     * @param $page integer
     * @param $status integer
     * @return mixed
     */
    static function get_requests_by_status($status, $count, $page) {
        global $_DATABASE;
        $offset = ($page - 1) * $count;
        $stmt = $_DATABASE->prepare("
          SELECT *, (
            SELECT request_status FROM request_meta
            WHERE request_meta.request_id = requests.request_id
            ORDER BY meta_id DESC
            LIMIT 1) as request_status,(
            SELECT meta_create FROM request_meta
            WHERE request_meta.request_id = requests.request_id
            ORDER BY meta_id DESC
            LIMIT 1) as request_update
          FROM requests
          WHERE IF(:request_status = 0, (
                SELECT request_status FROM request_meta
                WHERE request_meta.request_id = requests.request_id
                ORDER BY meta_id DESC
                LIMIT 1) IS NULL, (
                SELECT request_status FROM request_meta
                WHERE request_meta.request_id = requests.request_id
                ORDER BY meta_id DESC
                LIMIT 1) = :request_status)
          ORDER BY request_id DESC
          LIMIT {$offset}, {$count};
        ");
        $stmt->execute([
            'request_status' => $status
        ]);
        return $stmt->fetchAll();
    }

    /**
     * @param $status integer
     * @param $count integer
     * @return integer
     */
    static function get_status_page_count($status, $count) {
        global $_DATABASE;
        if ($count === 0) {
            return 1;
        }
        $stmt = $_DATABASE->prepare("
          SELECT count(1) as requests_count
          FROM requests
          WHERE IF(:request_status = 0, (
                SELECT request_status FROM request_meta
                WHERE request_meta.request_id = requests.request_id
                ORDER BY meta_id DESC
                LIMIT 1) IS NULL, (
                SELECT request_status FROM request_meta
                WHERE request_meta.request_id = requests.request_id
                ORDER BY meta_id DESC
                LIMIT 1) = :request_status);
        ");
        $stmt->execute([
            'request_status' => $status
        ]);
        return ceil($stmt->fetch()['requests_count'] / $count);
    }

    /**
     * @param $user integer
     * @param $count integer
     * @return int
     */
    static function get_user_page_count($user, $count) {
        global $_DATABASE;
        if ($count === 0) {
            return 1;
        }
        $stmt = $_DATABASE->prepare("
          SELECT count(1) as requests_count
          FROM requests
          WHERE request_user = :request_user
        ");
        $stmt->execute([
            'request_user' => $user
        ]);
        return ceil($stmt->fetch()['requests_count'] / $count);
    }

    /**
     * @param $count integer
     * @param $page integer
     * @param $user string
     * @return mixed
     */
    static function get_requests_by_user($user, $count, $page) {
        global $_DATABASE;
        $offset = ($page - 1) * $count;
        $stmt = $_DATABASE->prepare("
          SELECT *, (
            SELECT request_status FROM request_meta
            WHERE request_meta.request_id = requests.request_id
            ORDER BY meta_id DESC
            LIMIT 1) as request_status,(
            SELECT meta_create FROM request_meta
            WHERE request_meta.request_id = requests.request_id
            ORDER BY meta_id DESC
            LIMIT 1) as request_update
          FROM requests
          WHERE request_user = :request_user
          ORDER BY request_id DESC
          LIMIT {$offset}, {$count};
        ");
        $stmt->execute([
            'request_user' => $user
        ]);
        return $stmt->fetchAll();
    }

    /**
     * @param $count integer
     * @param $page integer
     * @param $division integer
     * @return mixed
     */
    static function get_requests_by_division($division, $count, $page) {
        global $_DATABASE;
        $offset = ($page - 1) * $count;
        $stmt = $_DATABASE->prepare("
          SELECT *, (
            SELECT request_status FROM request_meta
            WHERE request_meta.request_id = requests.request_id
            ORDER BY meta_id DESC
            LIMIT 1) as request_status,(
            SELECT meta_create FROM request_meta
            WHERE request_meta.request_id = requests.request_id
            ORDER BY meta_id DESC
            LIMIT 1) as request_update
          FROM requests
          WHERE request_division = :request_division
          ORDER BY request_id DESC
          LIMIT {$offset}, {$count};
        ");
        $stmt->execute([
            'request_division' => $division
        ]);
        return $stmt->fetchAll();
    }


    /**
     * @param $division integer
     * @param $count integer
     * @return integer
     */
    static function get_division_page_count($division, $count) {
        global $_DATABASE;
        if ($count === 0) {
            return 1;
        }
        $stmt = $_DATABASE->prepare("
          SELECT count(1) as requests_count
          FROM requests
          WHERE request_division = :request_division
        ");
        $stmt->execute([
            'request_division' => $division
        ]);
        return ceil($stmt->fetch()['requests_count'] / $count);
    }

    /**
     * @param $count integer
     * @param $page integer
     * @param $division integer
     * @param $status integer
     * @return mixed
     */
    static function get_requests_by_division_status($division, $status, $count, $page) {
        global $_DATABASE;
        $offset = ($page - 1) * $count;
        $stmt = $_DATABASE->prepare("
          SELECT *, (
            SELECT request_status FROM request_meta
            WHERE request_meta.request_id = requests.request_id
            ORDER BY meta_id DESC
            LIMIT 1) as request_status,(
            SELECT meta_create FROM request_meta
            WHERE request_meta.request_id = requests.request_id
            ORDER BY meta_id DESC
            LIMIT 1) as request_update
          FROM requests
          WHERE request_division = :request_division
            and IF(:request_status = 0, (
                SELECT request_status FROM request_meta
                WHERE request_meta.request_id = requests.request_id
                ORDER BY meta_id DESC
                LIMIT 1) IS NULL, (
                SELECT request_status FROM request_meta
                WHERE request_meta.request_id = requests.request_id
                ORDER BY meta_id DESC
                LIMIT 1) = :request_status)
          ORDER BY request_id DESC
          LIMIT {$offset}, {$count};
        ");
        $stmt->execute([
            'request_division' => $division,
            'request_status' => $status
        ]);
        return $stmt->fetchAll();
    }

    /**
     * @param $division integer
     * @param $status integer
     * @param $count integer
     * @return integer
     */
    static function get_division_status_page_count($division, $status, $count) {
        global $_DATABASE;
        if ($count === 0) {
            return 1;
        }
        $stmt = $_DATABASE->prepare("
          SELECT count(1) as requests_count
          FROM requests
          WHERE request_division = :request_division
            and IF(:request_status = 0, (
                SELECT request_status FROM request_meta
                WHERE request_meta.request_id = requests.request_id
                ORDER BY meta_id DESC
                LIMIT 1) IS NULL, (
                SELECT request_status FROM request_meta
                WHERE request_meta.request_id = requests.request_id
                ORDER BY meta_id DESC
                LIMIT 1) = :request_status)
        ");
        $stmt->execute([
            'request_division' => $division,
            'request_status' => $status
        ]);
        return ceil($stmt->fetch()['requests_count'] / $count);
    }

    /**
     * @param $request integer
     * @return array
     */
    static function get_requests_statuses($request) {
        global $_DATABASE;
        $stmt = $_DATABASE->prepare("
          SELECT request_status, status_set_user, meta_create as request_date
          FROM request_meta
          WHERE request_id = :request_id
          ORDER BY request_id DESC;
        ");
        $stmt->execute([
            'request_id' => $request
        ]);
        return $stmt->fetchAll();
    }

    /**
     * @param $author integer
     * @param $request integer
     * @return boolean
     */
    static function is_request_executor($author, $request) {
        global $_DATABASE;
        $stmt = $_DATABASE->prepare("
          SELECT COUNT(1) as exist
          FROM requests
            INNER JOIN request_meta
            ON requests.request_id = request_meta.request_id
          WHERE requests.request_user = :request_user
            and request_meta.status_set_user = :status_set_user
          LIMIT 1;
        ");
        $stmt->execute([
            'request_user' => $author,
            'status_set_user' => $request
        ]);
        return $stmt->fetch()['exist'] > 0;
    }


}
