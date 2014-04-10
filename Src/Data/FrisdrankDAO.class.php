<?php

namespace Src\Data;

use Src\Entities\Frisdrank;

class FrisdrankDAO extends DAO {
    /*     * getAll(): Haalt alle frisdrankgegevens op uit db en maakt er een array van objecten van
     * 
     * @return array van objecten: een array van frisdrankobjecten
     */

    public static function getAll() {
        $sql = "SELECT * FROM frisdrank";
        $stmt = parent::execPreppedStmt($sql);
        $resultSet = $stmt->fetchall();
        foreach ($resultSet as $rij) {
            $frisdrank = Frisdrank::create($rij['id'], $rij['type'], $rij['aantal'], $rij['prijs'], $rij['coords']);
            $arr[] = $frisdrank;
        }
        return $arr;
    }

    /*     * update: om de frisdranken te updaten
     * 
     * @param integer $drankAantal: het nieuwe aantal van de frisdranken
     * @param integer $drankId:optioneel frisdrankid om een frisdrank te verlagen
     */

    public static function update($drankAantal, $drankId = null) {
        if ($drankId !== null) {
            $sql = "UPDATE frisdrank SET aantal=? WHERE id=?";
        } else if ($drankId === null) {
            $sql = "UPDATE frisdrank SET aantal=?";
        }
        $args = Func_get_args();
        parent::execPreppedStmt($sql, $args);
    }

    /*     * getById():haalt drank op op basis van id
     * 
     * @param type $drankId:frisdrankid om de drank op te halen
     * @return object: frisdrankobject
     */

    public static function getById($drankId) {
        $sql = "SELECT * FROM frisdrank WHERE id=?";
        $args= func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $result = $stmt->fetch();
        $drank = Frisdrank::create($result['id'], $result['type'], $result['aantal'],  $result['prijs'], $result['coords']);
        return $drank;
    }

}
