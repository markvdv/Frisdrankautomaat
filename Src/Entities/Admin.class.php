<?php

namespace Src\Entities;

class Admin {

    // <editor-fold defaultstate="collapsed" desc="class variables">
    private $id;
    private $user;
    private $password;
    private static $idMap = array();

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="construct/create">

    private function __construct($id, $username, $password) {
        $this->id = $id;
        $this->user = $user;
        $this->password = $password;
    }

    public static function create($adminId, $username, $password) {
        if (!isset(self::$idMap[$adminId])) {
            self::$idMap[$adminId] = new Admin($adminId, $username, $password);
        }
        return self::$idMap[$adminId];
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="nodige getters en setters">
    public function getPassword() {
        return $this->password;
    }

    // </editor-fold>
}
