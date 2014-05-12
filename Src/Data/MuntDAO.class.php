<?php

namespace Src\Data;

use PDO;
use Src\Entities\Munt;

class MuntDAO extends DAO {
    /*     * getAll:haalt alle muntgegevens op en maakt er objecten van
     * 
     * @return array van muntobjecten
     */
    public static function getAll() {
        $sql = "SELECT * FROM munt";
        $stmt = parent::execPreppedStmt($sql);
        $resultSet = $stmt->fetchall(PDO::FETCH_ASSOC);
        $arr = array();
        foreach ($resultSet as $result) {
            $munt = Munt::create($result['id'], $result['waarde'], $result['aantal']);
            $arr[] = $munt;
        }
        return $arr;
    }

    /*     * update: om de munten te updaten
     * 
     * @param integer $muntAantal: het nieuwe aantal van de munten
     * @param integer $muntId:optioneel muntId om een munt te verlagen/verhogen
     */
    public static function update($muntAantal, $muntId = null) {
        if ($muntId !== null) {
            $sql = "UPDATE munt SET aantal=? WHERE id=?";
            $args = func_get_args();
        } else if ($muntId === null) {
            $sql = "UPDATE munt SET aantal=?";
            $args = array();
            $args[] = $muntAantal;
        }
        $stmt=parent::execPreppedStmt($sql, $args);
        return $stmt;
    }

    public static function getById($muntId) {
        $sql = "SELECT * FROM munt where id=?";
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $munt = Munt::create($result['id'], $result['waarde'], $result['aantal']);
        return $munt;
    }

}
