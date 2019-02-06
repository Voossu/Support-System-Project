<?php namespace lib\model;

abstract class Divisions {

    /**
     * @param $name string
     * @param null $description string
     * @return integer|null|string
     */
    static function new_division($name, $description = null) {
        global $_DATABASE;
        return $_DATABASE->prepare("
          INSERT INTO divisions (division_name, division_description)
          VALUES (:division_name, :division_description);
        ")->execute([
            'division_name' => $name,
            'division_description' => $description
        ]) ? $_DATABASE->lastInsertId() : null;
    }

    /**
     * @param $id integer
     * @return bool
     */
    static function delete_division($id) {
        global $_DATABASE;
        return $_DATABASE->prepare("
          DELETE FROM divisions
          WHERE division_id = :division_id;
        ")->execute([
            'division_id' => $id
        ]);
    }

    /**
     * @param $id integer
     * @param $name string
     * @param null $description string
     * @return bool
     */
    static function update_division($id, $name, $description = null) {
        global $_DATABASE;
        return $_DATABASE->prepare("
          UPDATE divisions
          SET division_name = :division_name,
              division_description = :division_description
          WHERE division_id = :division_id;
        ")->execute([
            'division_id' => $id,
            'division_name' => $name,
            'division_description' => $description
        ]);
    }

    /**
     * @param $id integer
     * @return mixed|null
     */
    static function get_division($id) {
        global $_DATABASE;
        $stmt = $_DATABASE->prepare("
          SELECT *
          FROM divisions
          WHERE division_id = :division_id;
        ");
        $stmt->execute([
            'division_id' => $id
        ]);
        return $stmt->fetch();
    }

    /**
     * @param $cont integer
     * @param $page integer
     * @return array(mixed)|null
     */
    static function get_divisions($cont, $page) {
        global $_DATABASE;
        $offset = ($page - 1) * $cont;
        $stmt = $_DATABASE->prepare("
          SELECT *
          FROM divisions
          LIMIT {$offset}, {$cont};
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static function get_all_divisions() {
        global $_DATABASE;
        $stmt = $_DATABASE->prepare("
          SELECT *
          FROM divisions
          ORDER BY division_name;
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

}