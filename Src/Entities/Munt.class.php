<?php
namespace Src\Entities;
class Munt {

    // <editor-fold defaultstate="collapsed" desc="classvariables">
    private $id;
    private $waarde;
    private $aantal;
    private static $idMap=array();
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="construct">
    private function __construct($id, $waarde, $aantal) {
        $this->id = $id;
        $this->waarde = $waarde;
        $this->aantal = $aantal;
    }
    public static function create($muntId,$waarde,$aantal) {
        if (!isset (self::$idMap[$muntId])){
            self::$idMap[$muntId]=new Munt($muntId, $waarde, $aantal);
        }
        return self::$idMap[$muntId];
    }
// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="getters en setters">
    public function getId() {
        return $this->id;
    }

    public function getWaarde() {
        return $this->waarde;
    }

    public function getAantal() {
        return $this->aantal;
    }

    public function setAantal($aantal) {
        $this->aantal = $aantal;
    }

// </editor-fold>


}
