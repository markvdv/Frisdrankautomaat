<?php

namespace Src\Business;

use Src\Data\FrisdrankDAO;

class FrisdrankService {
    /*     * $maximumDrankAantal
     *
     * @var integer  static variable voor het maximum aantal dranken  
     */

    private static $maximumDrankAantal = 20;

    /*     * haalFrisdrankenOp:Haalt de frisdranken lijst op
     * 
     * @return array van frisdrankobjecten
     */

    public static function haalFrisdrankenOp() {
        $lijst = FrisdrankDAO::getAll();
        return $lijst;
    }

    /*     * geefFrisdrank:Geeft een frisdrank aan de klant en vermindert het aantal in de automaat
     * 
     */

    public static function geefFrisdrank($iDrankid) {
        $drank = FrisdrankDAO::getById($iDrankid);
        $drank->setAantal($drank->getAantal() - 1);
        FrisdrankDAO::update($drank->getAantal(), $iDrankid);
    }

    /*     * vulFrisdrankenBij:Vult alle frisdranken terug bij tot het maximum aantal
     * 
     */

    public static function vulFrisdrankenBij() {
        FrisdrankDAO::update(self::$maximumDrankAantal);
    }

}
