<?php

namespace Src\Entities;

class Frisdrank {

    // <editor-fold defaultstate="collapsed" desc="class variables">
    private $id;
    private $type;
    private $aantal;
    private $prijs;
    private $coords;
    private static $idMap = array();

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="__construct/create">

    private function __construct($id, $type, $aantal, $prijs, $coords) {
        $this->id = $id;
        $this->type = $type;
        $this->aantal = $aantal;
        $this->prijs = $prijs;
        $this->coords = $coords;
    }

    public static function create($id, $type, $aantal, $prijs, $coords) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Frisdrank($id, $type, $aantal, $prijs, $coords);
        }
        return self::$idMap[$id];
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="nodige getters en setters">
    public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->type;
    }

    public function getAantal() {
        return $this->aantal;
    }

    public function getPrijs() {
        return $this->prijs;
    }

    public function setAantal($aantal) {
        $this->aantal = $aantal;
    }

    public function setPrijs($prijs) {
        $this->prijs = $prijs;
    }

    public function getCoords() {
        return $this->coords;
    }

// </editor-fold>
}
